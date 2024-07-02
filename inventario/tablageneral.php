<?php
    include_once "../login/verificar_sesion.php";
    require_once("./inventario.php");

    // Crear una instancia de la clase Inventario
    $inventario = new Inventario(null, null, null, null, null);

    // Obtener detalles de ingresos
    $detallesIngresos = $inventario->obtenerDetalleIngresos();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de Ingresos</title>
    <!-- Agregar estilos de Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Agregar estilos de DataTables -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <!-- Agregar Font Awesome para los íconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Estilos adicionales -->
    <style>
        body {
            padding-top: 20px; /* Ajuste para el menú fijo */
        }
        
        .table-responsive {
            overflow-x: auto;
        }
        
        table#tablaIngresos {
            width: 100% !important; /* Asegura que la tabla ocupe todo el ancho disponible */
        }
        
        #tablaIngresos th,
        #tablaIngresos td {
            text-align: center; /* Centrar el texto en todas las celdas */
        }
        
        #tablaIngresos th:first-child,
        #tablaIngresos td:first-child {
            font-weight: bold; /* Hace que el texto en la primera columna (ID Producto) sea negrita */
        }
    </style>
</head>
<body>
    <div class="container-fluid" style="width: 90%;">
        <h1 class="mt-5 mb-3">Detalles de Ingresos</h1>
        <div class="table-responsive">
            <table id="tablaIngresos" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID Ingreso</th>
                        <th>Fecha de Ingreso</th>
                        <th>ID Producto</th>
                        <th>Nombre Producto</th>
                        <th>Peso</th>
                        <th>Valor por Kilo</th>
                        <th>Nombre Usuario</th>
                        <th>Nombre Proveedor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($detallesIngresos) {
                        foreach ($detallesIngresos as $detalle) {
                            echo "<tr>";
                            echo "<td>" . $detalle['id_ingreso'] . "</td>";
                            echo "<td>" . $detalle['fecha_ingreso'] . "</td>";
                            echo "<td>" . $detalle['id_producto'] . "</td>";
                            echo "<td>" . $detalle['nombre_producto'] . "</td>";
                            echo "<td>" . number_format($detalle['peso'], 0, ',', '.') . "</td>";
                            echo "<td>$" . number_format($detalle['valor_por_kilo'], 0, ',', '.') . "</td>";
                            echo "<td>" . $detalle['nombre_usuario'] . "</td>";
                            echo "<td>" . $detalle['nombre_proveedor'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center'>No se encontraron datos de ingresos.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Agregar scripts de DataTables y Bootstrap al final del cuerpo del documento -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inicializar DataTables
            $('#tablaIngresos').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json"
                }
            });
        });
    </script>
</body>
</html>
