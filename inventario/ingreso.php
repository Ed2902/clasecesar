<?php
include_once "../login/verificar_sesion.php";
require_once("../conexion.php");

class Ingreso {
    protected $suma_total_kilos;
    protected $fecha_hora;
    protected $factura;
    protected $ordenCompra;
    protected $reciboPago;

    public function __construct($suma_total_kilos, $fecha_hora = null, $factura = null, $ordenCompra = null, $reciboPago = null) {
        $this->suma_total_kilos = $suma_total_kilos;
        $this->fecha_hora = $fecha_hora ? $fecha_hora : date("Y-m-d H:i:s");
        $this->factura = $factura;
        $this->ordenCompra = $ordenCompra;
        $this->reciboPago = $reciboPago;
    }

    // Getters y setters para suma_total_kilos y fecha_hora
    public function getSumaTotalKilos() {
        return $this->suma_total_kilos;
    }

    public function getFechaHora() {
        return $this->fecha_hora;
    }

    public function setSumaTotalKilos($suma_total_kilos) {
        $this->suma_total_kilos = $suma_total_kilos;
    }

    public function setFechaHora($fecha_hora) {
        $this->fecha_hora = $fecha_hora;
    }

    // Getters y setters para factura, ordenCompra y reciboPago
    public function getFactura() {
        return $this->factura;
    }

    public function setFactura($factura) {
        $this->factura = $factura;
    }

    public function getOrdenCompra() {
        return $this->ordenCompra;
    }

    public function setOrdenCompra($ordenCompra) {
        $this->ordenCompra = $ordenCompra;
    }

    public function getReciboPago() {
        return $this->reciboPago;
    }

    public function setReciboPago($reciboPago) {
        $this->reciboPago = $reciboPago;
    }

    public function guardar() {
        $conexion = new Conexion();

        try {
            $conexion->beginTransaction();

            // Insertar en la tabla 'ingreso'
            $consultaIngreso = $conexion->prepare("INSERT INTO ingreso (suma_total_kilos, fecha_hora) VALUES (:suma_total_kilos, :fecha_hora)");
            $consultaIngreso->bindParam(':suma_total_kilos', $this->suma_total_kilos);
            $consultaIngreso->bindParam(':fecha_hora', $this->fecha_hora);
            $consultaIngreso->execute();

            // Obtener el ID del último ingreso insertado
            $idIngreso = $conexion->lastInsertId();

            // Confirmar la transacción
            $conexion->commit();

            return $idIngreso; // Devolver el ID del ingreso insertado
        } catch (PDOException $e) {
            // Revertir la transacción si hay un error
            $conexion->rollback();
            error_log("Error al guardar ingreso: " . $e->getMessage());
            return false; // Error
        }
    }

    public function mostrarIngresos() {
        $conexion = new Conexion();
        $consulta = $conexion->query("SELECT * FROM ingreso");
        $ingresos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $conexion = null;
        return $ingresos;
    }

    public function mostrarDetalleIngreso($idIngreso) {
        $conexion = new Conexion();
        $consulta = $conexion->prepare("SELECT d.*, i.id_proveedorFK, i.valorPorKilo, p.nombre AS nombre_proveedor
                                        FROM detalle_ingreso d
                                        INNER JOIN inventario i ON d.id_inventarioFK = i.id_inventario
                                        INNER JOIN proveedor p ON i.id_proveedorFK = p.id_proveedor
                                        WHERE d.ingreso_id = :idIngreso");
        $consulta->bindParam(':idIngreso', $idIngreso);
        $consulta->execute();
        $detalles = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $conexion = null;
        return $detalles;
    }

    public static function obtenerProveedores() {
        $conexion = new Conexion();
        $consulta = $conexion->query("SELECT id_proveedor, nombre FROM proveedor");
        $proveedores = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $conexion = null;
        return $proveedores;
    }

    public static function buscarProductos($termino) {
        $conexion = new Conexion();
        $stmt = $conexion->prepare("SELECT id_producto, nombre, referencia, tipo FROM producto WHERE nombre LIKE ? OR referencia LIKE ?");
        $stmt->execute(['%'.$termino.'%', '%'.$termino.'%']);
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $conexion = null;
        return $productos;
    }
    
    public function obtenerDetalleIngreso($idIngreso) {
        $conexion = new Conexion();
        try {
            $consulta = $conexion->prepare(" SELECT 
                    ing.id AS id_ingreso,
                    ing.fecha_hora AS fecha_ingreso,
                    p.id_producto AS id_producto,
                    p.nombre AS nombre_producto,
                    inv.peso AS peso,
                    inv.valorPorKilo AS valor_por_kilo,
                    u.nombre AS nombre_usuario,
                    prov.nombre AS nombre_proveedor
                FROM 
                    ingreso ing
                INNER JOIN 
                    detalle_ingreso di ON ing.id = di.ingreso_id
                INNER JOIN 
                    inventario inv ON di.id_inventarioFK = inv.id_inventario
                INNER JOIN 
                    producto p ON inv.id_productoFK = p.id_producto
                INNER JOIN 
                    usuario u ON inv.id_usuario = u.id_usuario
                INNER JOIN 
                    proveedor prov ON inv.id_proveedor = prov.id_proveedor
                WHERE 
                    ing.id = :idIngreso
            ");
            $consulta->bindParam(':idIngreso', $idIngreso, PDO::PARAM_INT);
            $consulta->execute();
    
            // Verificar si la consulta devolvió resultados
            if ($consulta === false) {
                throw new PDOException('Error en la consulta SQL');
            }
    
            $detalles = [];
            if ($consulta->rowCount() > 0) {
                while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    $detalles[] = $fila;
                }
            } else {
                error_log('No se encontraron registros en la consulta de ingresos.');
            }
    
            return $detalles;
        } catch (PDOException $e) {
            error_log("Error al obtener detalles de ingresos: " . $e->getMessage());
            return false; // Error
        } finally {
            $conexion = null;
        }
    }
    
    public function subirArchivo($id, $campo, $archivo) {
        // Determinar la carpeta de destino según el campo
        $carpetaDestino = '';
        if ($campo === 'factura') {
            $carpetaDestino = 'documentos/factura/';
        } elseif ($campo === 'ordenCompra') {
            $carpetaDestino = 'documentos/ordencompra/';
        } elseif ($campo === 'reciboPago') {
            $carpetaDestino = 'documentos/recibopago/';
        }
    
        // Verificar si la carpeta de destino existe, si no, crearla
        if (!is_dir($carpetaDestino)) {
            mkdir($carpetaDestino, 0777, true);
        }
    
        // Obtener la extensión del archivo
        $fileExtension = strtolower(pathinfo($archivo["name"], PATHINFO_EXTENSION));
    
        // Verificar si el archivo es un documento permitido
        $allowedExtensions = ["pdf", "doc", "docx", "txt", "jpeg", "jpg"];
        if (!in_array($fileExtension, $allowedExtensions)) {
            return "Solo se permiten archivos PDF, DOC, DOCX, TXT, JPEG y JPG.";
        }
    
        // Crear el nuevo nombre del archivo
        $nuevoNombre = $id . '_' . $campo . '.' . $fileExtension;
        $targetFile = $carpetaDestino . $nuevoNombre;
    
        // Verificar si hubo algún error al subir el archivo
        if (move_uploaded_file($archivo["tmp_name"], $targetFile)) {
            // Actualizar la base de datos con la ruta del archivo subido
            try {
                $conexion = new Conexion();
                $consulta = $conexion->prepare("UPDATE ingreso SET $campo = :ruta WHERE id = :id");
                $consulta->bindParam(':ruta', $targetFile);
                $consulta->bindParam(':id', $id);
                $consulta->execute();
                return "El archivo " . htmlspecialchars($nuevoNombre) . " ha sido subido y guardado en la base de datos.";
            } catch (PDOException $e) {
                return "Error al actualizar la base de datos: " . $e->getMessage();
            }
        } else {
            return "Hubo un error al subir el archivo.";
        }
    }

    public function obtenerDocumentosIngreso($idIngreso) {
        $conexion = new Conexion();
        try {
            $consulta = $conexion->prepare("SELECT factura, ordenCompra, reciboPago FROM ingreso WHERE id = :idIngreso");
            $consulta->bindParam(':idIngreso', $idIngreso, PDO::PARAM_INT);
            $consulta->execute();

            $documentos = $consulta->fetch(PDO::FETCH_ASSOC);
            return $documentos;
        } catch (PDOException $e) {
            error_log("Error al obtener documentos de ingresos: " . $e->getMessage());
            return false; // Error
        } finally {
            $conexion = null;
        }
    }

    public function sumarValoresPorKilo($idIngreso) {
        $conexion = new Conexion();
        $consulta = $conexion->prepare("SELECT SUM(i.valorPorKilo * i.peso)
                                        FROM detalle_ingreso di
                                        INNER JOIN inventario i ON di.id_inventarioFK = i.id_inventario
                                        WHERE di.ingreso_id = :idIngreso");
        $consulta->bindParam(':idIngreso', $idIngreso, PDO::PARAM_INT);
        $consulta->execute();
        $suma = $consulta->fetchColumn();
        $conexion = null;
        return $suma;
    }
}
?>
