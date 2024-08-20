<?php
include_once "../login/verificar_sesion.php";
require_once("../conexion.php");
require_once("../inventario/ingreso.php");

// Obtener los datos de los ingresos
$ingresos = [];
try {
    $ingreso = new Ingreso(0); // La suma_total_kilos no es relevante aquí
    $ingresos = $ingreso->mostrarIngresos();
} catch (Exception $e) {
    $error = $e->getMessage();
}

// Obtener la suma de valores por kilo para cada ingreso
foreach ($ingresos as &$ingreso) {
    try {
        $ingresoObj = new Ingreso(0);
        $ingreso['suma_valores_por_kilo'] = $ingresoObj->sumarValoresPorKilo($ingreso['id']);
    } catch (Exception $e) {
        $ingreso['suma_valores_por_kilo'] = 0;
    }
}
unset($ingreso); // Desreferenciar la variable para evitar conflictos

// Manejar la subida de archivos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['archivo'])) {
    $id = $_POST['id'];
    $campo = $_POST['campo'];
    $archivo = $_FILES['archivo'];

    try {
        $ingreso = new Ingreso(0); // La suma_total_kilos no es relevante aquí
        $resultado = $ingreso->subirArchivo($id, $campo, $archivo);
        echo $resultado;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    exit;
}

// Obtener detalles de ingreso para el modal
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['detalle_id'])) {
    try {
        $ingreso = new Ingreso(0); // La suma_total_kilos no es relevante aquí
        $detalles = $ingreso->obtenerDetalleIngreso($_GET['detalle_id']);
        echo json_encode($detalles);
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
}

// Obtener documentos de ingreso para el modal
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['documentos_id'])) {
    try {
        $ingreso = new Ingreso(0); // La suma_total_kilos no es relevante aquí
        $documentos = $ingreso->obtenerDocumentosIngreso($_GET['documentos_id']);
        echo json_encode($documentos);
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Datos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/colreorder/1.5.2/css/colReorder.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <div class="container-fluid" style="width: 90%;">
        <a href="../Home/home.php" style="text-decoration: none;">
            <button type="button" class="btn btn-light mr-2" style="border-radius: 50%;">
                <i class="fas fa-home" style="font-size: 20px; color:#fe5000;"></i>
            </button>
        </a>
        <h1 class="mt-5 mb-3">Tabla de Datos</h1>

        <!-- Contenedor flex para los botones a la izquierda y la fecha a la derecha -->
        <div class="d-flex mb-3">
        <div>
            <a href="../inventario/ingresar_inventario.php" class="btn btn-success mr-2">
                <span class="me-2">+</span> Agregar
            </a>
            <a href="../inventario/tablageneral.php" class="btn btn-warning">
                Editar Inventario
            </a>
        </div>
            <div class="ml-auto">
                <div class="form-group">
                    <label for="dateRange">Rango de Fechas:</label>
                    <div class="input-group">
                        <input type="text" id="dateRange" class="form-control">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fas fa-calendar-alt"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table id="data-table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha y Hora</th>
                        <th>Suma Total Kilos</th>
                        <th>Suma de Valores por Kilo</th>
                        <th>Documentos</th>
                        <th>Detalle</th>
                    </tr>
                </thead>
                <tbody id="data-table-body">
                    <?php if (!empty($ingresos)): ?>
                        <?php foreach ($ingresos as $ingreso): ?>
                            <?php
                                $todosDocumentos = $ingreso['factura'] && $ingreso['ordenCompra'] && $ingreso['reciboPago'];
                                $algunDocumento = $ingreso['factura'] || $ingreso['ordenCompra'] || $ingreso['reciboPago'];
                                $icono = $todosDocumentos ? '✔' : ($algunDocumento ? '!' : '✘');
                                $claseIcono = $todosDocumentos ? 'green' : ($algunDocumento ? 'yellow' : 'red');
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($ingreso['id']) ?></td>
                                <td><?= htmlspecialchars($ingreso['fecha_hora']) ?></td>
                                <td><?= htmlspecialchars($ingreso['suma_total_kilos']) ?></td>
                                <td><?= htmlspecialchars($ingreso['suma_valores_por_kilo']) ?></td>
                                <td>
                                    <button class="btn btn-primary" onclick="showDocuments(<?= htmlspecialchars($ingreso['id']) ?>)">Documentos</button>
                                    <span class="status-icon <?= $claseIcono ?>"><?= $icono ?></span>
                                </td>
                                <td><button class="btn btn-info" onclick="showDetails(<?= htmlspecialchars($ingreso['id']) ?>)">Detalle</button></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">No hay datos disponibles</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para documentos -->
    <div id="detailModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="modal-body"></div>
        </div>
    </div>

    <!-- Modal para detalles -->
    <div id="detailsModal" class="modal">
        <div class="modal-content modal-detail-content">
            <span class="close">&times;</span>
            <div id="modal-body-detail"></div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/colreorder/1.5.2/js/dataTables.colReorder.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="./tabladatos.js"></script>
</body>
</html>
                        