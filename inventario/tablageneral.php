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
        <!-- Botón de Casa y Flecha hacia atrás -->
        <a href="../Home/home.php" style="text-decoration: none;">
            <button type="button" class="btn btn-light mr-2" style="border-radius: 50%;">
                <i class="fas fa-home" style="font-size: 20px; color:#fe5000;"></i>
            </button>
        </a>
        <a href="javascript:history.back()" style="text-decoration: none;">
            <button type="button" class="btn btn-light mr-2" style="border-radius: 50%;">
                <i class="fas fa-arrow-left" style="font-size: 20px; color:#fe5000;"></i>
            </button>
        </a>
        <h1 class="mt-5 mb-3">Detalles de Ingresos</h1>
        <!-- Campo de búsqueda por fecha -->
        <div class="form-group row justify-content-end">
            <label for="filtroFecha" class="col-md-2 col-form-label text-right">Buscar por Fecha:</label>
            <div class="col-md-3">
                <input type="text" class="form-control" id="filtroFecha" placeholder="YYYY-MM-DD">
            </div>
            <!-- Icono de Descargar PDF -->
            <i id="descargarPDF" class="fas fa-file-pdf" style="color: #74C0FC; font-size: 30px; padding:2px"></i>

            <!-- Icono de Descargar Excel -->
            <i id="descargarExcel" class="fas fa-file-excel" style="font-size: 30px; color:#fe5000; padding:2px; margin-right:11px"></i>
        </div>

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
                        <th>Acciones</th> <!-- Nueva columna para las acciones -->
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
                            echo "<td><button class='btn btn-primary btn-edit' data-id='" . $detalle['id_ingreso'] . "'><i class='fas fa-edit'></i></button></td>"; // Botón de edición
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9' class='text-center'>No se encontraron datos de ingresos.</td></tr>";
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inicializar DataTables
            $('#tablaIngresos').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json"
                }
            });

            // Agregar la funcionalidad de filtro por fecha
            $('#filtroFecha').on('keyup change', function() {
                var fecha = $('#filtroFecha').val();
                $('#tablaIngresos').DataTable().column(1).search(fecha).draw();
            });

            // Manejar el clic en el botón de edición
            $(document).on('click', '.btn-edit', function() {
                var idIngreso = $(this).data('id');
                // Redirigir a la página de edición
                window.location.href = 'editar_ingreso.php?id=' + idIngreso;
            });
        });

        // Script para manejar la descarga de PDF
        document.getElementById('descargarPDF').addEventListener('click', function() {
            var tabla = document.getElementById('tablaIngresos');
            var fecha = document.getElementById('filtroFecha').value;
            var filename = 'Detalles_Ingresos_' + (fecha ? fecha : 'Sin_Fecha') + '.pdf';
            html2pdf(tabla, {
                margin: 1,
                filename: filename,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' }
            });
        });

        // Script para manejar la descarga de Excel
        document.getElementById('descargarExcel').addEventListener('click', function() {
            var tabla = document.getElementById('tablaIngresos');
            var html = tabla.outerHTML;
            var url = 'data:application/vnd.ms-excel,' + encodeURIComponent(html);
            var link = document.createElement('a');
            link.download = 'Detalles_Ingresos.xls';
            link.href = url;
            link.click();
        });
    </script>
</body>
</html>
