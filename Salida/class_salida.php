<?php
require_once("../conexion.php"); 

class Salida {
    private $suma_total_kilos;
    private $fecha_hora;
    private $valor_total;
    private $clienteFK;
    private $id_usuarioFK;
    private $id_productoFK;
    private $conexion;

    public function __construct($suma_total_kilos, $clienteFK, $id_usuarioFK, $id_productoFK) {
        $this->conexion = new Conexion();
        $this->suma_total_kilos = $suma_total_kilos;
        $this->clienteFK = $clienteFK;
        $this->id_usuarioFK = $id_usuarioFK;
        $this->id_productoFK = $id_productoFK;
        $this->fecha_hora = date("Y-m-d H:i:s"); // Asignar fecha y hora del sistema al crear la instancia
        $this->valor_total = $this->calcularValorTotal($id_productoFK); // Calcular el valor total al crear la instancia
    }

    // Método para calcular el valor total basado en el inventario
    private function calcularValorTotal($id_productoFK) {
        $consulta = $this->conexion->prepare("SELECT AVG(valorPorKilo) as valor_promedio FROM inventario WHERE id_productoFK = :id_productoFK");
        $consulta->bindParam(':id_productoFK', $id_productoFK);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado ? $resultado['valor_promedio'] * $this->suma_total_kilos : 0;
    }

    // Método para guardar la salida en la base de datos
    public function registrarSalidaDesdeJson($jsonData) {
        try {
            // Decodificar el JSON en un array
            $productos = json_decode($jsonData, true);
    
            // Iniciar transacción
            $this->conexion->beginTransaction();
    
            // Iterar sobre cada producto en el JSON
            foreach ($productos as $producto) {
                // Extraer datos del producto
                $id_productoFK = $producto['id_productoFK'];
                $id_usuarioFK = $producto['id_usuarioFK'];
                $peso = $producto['peso'];
                $clienteFK = $producto['id_clienteFK'];
    
                // Calcular suma_total_kilos (en este caso igual a $peso para cada producto)
                $suma_total_kilos = $peso;
    
                // Calcular valor_total basado en el producto
                $valor_total = $this->calcularValorTotal($id_productoFK);
    
                // Guardar en la tabla 'salida'
                $consultaSalida = $this->conexion->prepare(
                    "INSERT INTO salida (suma_total_kilos, fecha_hora, valor_total, clienteFK, id_usuarioFK, id_productoFK) 
                     VALUES (:suma_total_kilos, NOW(), :valor_total, :clienteFK, :id_usuarioFK, :id_productoFK)"
                );
                $consultaSalida->bindParam(':suma_total_kilos', $suma_total_kilos);
                $consultaSalida->bindParam(':valor_total', $valor_total);
                $consultaSalida->bindParam(':clienteFK', $clienteFK);
                $consultaSalida->bindParam(':id_usuarioFK', $id_usuarioFK);
                $consultaSalida->bindParam(':id_productoFK', $id_productoFK);
                $consultaSalida->execute();
    
                // Obtener el ID de la salida recién insertada
                $id_salida = $this->conexion->lastInsertId();
    
                // Guardar en la tabla 'detalle_salida'
                $consultaDetalleSalida = $this->conexion->prepare(
                    "INSERT INTO detalle_salida (id_salida) VALUES (:id_salida)"
                );
                $consultaDetalleSalida->bindParam(':id_salida', $id_salida);
                $consultaDetalleSalida->execute();
    
                // Actualizar la tabla 'consolidado_inventario' restando el peso
                $consultaActualizarConsolidado = $this->conexion->prepare(
                    "UPDATE consolidado_inventario 
                     SET existencia = existencia - :peso 
                     WHERE id_productoFK = :id_productoFK"
                );
                $consultaActualizarConsolidado->bindParam(':peso', $peso);
                $consultaActualizarConsolidado->bindParam(':id_productoFK', $id_productoFK);
                $consultaActualizarConsolidado->execute();
            }
    
            // Confirmar la transacción
            $this->conexion->commit();
            return true; // Éxito
        } catch (Exception $e) {
            // Revertir la transacción si hay un error
            $this->conexion->rollback();
            error_log("Error al registrar la salida: " . $e->getMessage());
            return false; // Error
        }
    }
    
    
    public function obtenerSalidasConDetalles() {
        try {
            // Consulta SQL con JOIN para obtener los nombres correspondientes a las claves foráneas
            $consulta = $this->conexion->prepare(
                "SELECT 
                    s.id,
                    s.suma_total_kilos,
                    s.fecha_hora,
                    s.valor_total,
                    s.evidencia,
                    s.documentacion,
                    c.nombre AS nombre_cliente,
                    u.nombre AS nombre_usuario,
                    p.nombre AS nombre_producto
                FROM 
                    salida s
                JOIN 
                    cliente c ON s.clienteFK = c.id_cliente
                JOIN 
                    usuario u ON s.id_usuarioFK = u.id_usuario
                JOIN 
                    producto p ON s.id_productoFK = p.id_producto"
            );
    
            // Ejecutar la consulta
            $consulta->execute();
    
            // Obtener los resultados
            $salidas = $consulta->fetchAll(PDO::FETCH_ASSOC);
    
            // Devolver los resultados en formato JSON
            return json_encode(array("success" => true, "salidas" => $salidas));
    
        } catch (Exception $e) {
            // Manejo de errores
            return json_encode(array("success" => false, "message" => "Error al obtener las salidas: " . $e->getMessage()));
        }
    }

    // Método para subir archivo de evidencia
    public function subirArchivoEvidencia($id_salida, $archivo) {
        $rutaDirectorio = "../Salida/evidencia/";
        return $this->guardarArchivo($id_salida, $archivo, $rutaDirectorio, 'evidencia');
    }

    // Método para subir archivo de documentación
    public function subirArchivoDocumentacion($id_salida, $archivo) {
        $rutaDirectorio = "../Salida/documentacion/";
        return $this->guardarArchivo($id_salida, $archivo, $rutaDirectorio, 'documentacion');
    }

    // Método general para guardar un archivo y actualizar la base de datos
    private function guardarArchivo($id_salida, $archivo, $rutaDirectorio, $campoBD) {
        try {
            $nombreArchivo = basename($archivo['name']);
            $rutaArchivo = $rutaDirectorio . $nombreArchivo;

            if (move_uploaded_file($archivo['tmp_name'], $rutaArchivo)) {
                // Actualizar la ruta del archivo en la base de datos
                $consulta = $this->conexion->prepare(
                    "UPDATE salida SET $campoBD = :rutaArchivo WHERE id = :id_salida"
                );
                $consulta->bindParam(':rutaArchivo', $rutaArchivo);
                $consulta->bindParam(':id_salida', $id_salida);
                $consulta->execute();

                return "Archivo subido y ruta actualizada correctamente.";
            } else {
                return "Error al subir el archivo.";
            }
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // Método para obtener la lista de productos desde la tabla 'producto'
public function obtenerProductos() {
    try {
        // Consulta SQL para obtener los datos necesarios de la tabla 'producto'
        $consulta = $this->conexion->prepare(
            "SELECT 
                id_producto, 
                nombre, 
                referencia, 
                tipo 
            FROM 
                producto"
        );

        // Ejecutar la consulta
        $consulta->execute();

        // Obtener los resultados
        $productos = $consulta->fetchAll(PDO::FETCH_ASSOC);

        // Devolver los resultados en formato JSON
        return json_encode(array("success" => true, "productos" => $productos));

    } catch (Exception $e) {
        // Manejo de errores
        return json_encode(array("success" => false, "message" => "Error al obtener los productos: " . $e->getMessage()));
    }
}

// Método para obtener la lista de clientes desde la tabla 'cliente'
public function obtenerClientes() {
    try {
        // Consulta SQL para obtener los datos necesarios de la tabla 'cliente'
        $consulta = $this->conexion->prepare(
            "SELECT 
                id_cliente, 
                nombre 
            FROM 
                cliente"
        );

        // Ejecutar la consulta
        $consulta->execute();

        // Obtener los resultados
        $clientes = $consulta->fetchAll(PDO::FETCH_ASSOC);

        // Devolver los resultados en formato JSON
        return json_encode(array("success" => true, "clientes" => $clientes));

    } catch (Exception $e) {
        // Manejo de errores
        return json_encode(array("success" => false, "message" => "Error al obtener los clientes: " . $e->getMessage()));
    }
}

    
}

?>
