<?php
include_once "../login/verificar_sesion.php";
require_once("./inventario.php");

$inventario = new Inventario(null, null, null, null, null);

// Calcular los totales de cantidad en kilos y valor
$totales = $inventario->calcularTotalesProducto();

// Obtener los detalles del inventario
$detalles = $inventario->obtenerDetallesInventario();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario Fast Way</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/colreorder/1.5.2/css/colReorder.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 20px;
        }
        
        .table-responsive {
            overflow-x: auto;
        }
        
        table#tablaInventario {
            width: 100% !important;
        }
        
        #tablaInventario th,
        #tablaInventario td {
            text-align: center;
        }
        
        #tablaInventario th:first-child,
        #tablaInventario td:first-child {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container-fluid" style="width: 90%;">
        <a href="../Home/home.php" style="text-decoration: none;">
            <button type="button" class="btn btn-light mr-2" style="border-radius: 50%;">
                <i class="fas fa-home" style="font-size: 20px; color:#fe5000;"></i>
            </button>
        </a>
        <h1 class="mt-5 mb-3">Mi inventario General</h1>

        <div class="d-flex justify-content-between mb-3">
            <div>
                <a href="./ingresar_inventario.php" class="btn btn-success"><i class="fas fa-plus"></i> Agregar</a>
                <a href="../ingresos/mostar_ingresos.php" class="btn btn-danger"><i class="fas fa-edit"></i> Ver Ingresos y Documentación</a>
            </div>
        </div>

        <div class="table-responsive">
            <table id="tablaInventario" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID Producto</th>
                        <th>Nombre Producto</th>
                        <th>Referencia</th>
                        <th>Tipo</th>
                        <th>Total kilos</th>
                        <th>Promedio Valor por kilo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($detalles as $detalle): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($detalle['id_producto']); ?></td>
                            <td><?php echo htmlspecialchars($detalle['nombre_producto']); ?></td>
                            <td><?php echo htmlspecialchars($detalle['referencia']); ?></td>
                            <td><?php echo htmlspecialchars($detalle['tipo']); ?></td>
                            <td><?php echo number_format($detalle['total_kilos'], 0, ',', '.'); ?></td>
                            <td><?php echo '$' . number_format($detalle['promedio_valor_por_kilo'], 2, ',', '.'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">Totales</td>
                        <td><?php echo number_format($totales['total_cantidad'], 0, ',', '.'); ?></td>
                        <td></td> <!-- Esta celda se deja vacía, sin mostrar ningún total para el promedio -->
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/colreorder/1.5.2/js/dataTables.colReorder.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#tablaInventario').DataTable({
                colReorder: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        text: '<i class="fas fa-copy"></i> Copiar',
                        className: 'btn btn-info'
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        className: 'btn btn-success'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        className: 'btn btn-danger'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Imprimir',
                        className: 'btn btn-light'
                    }
                ],
                initComplete: function() {
                    $('.dt-button').removeClass('dt-button').addClass('btn');
                },
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json"
                }
            });
        });
    </script>
</body>
</html>
