<?php
include_once "../login/verificar_sesion.php";
require_once("../conexion.php");
require_once("../Salida/class_salida.php");

// Procesar la subida de archivos de evidencia o documentación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['archivo'])) {
    $id_salida = $_POST['id_salida'];
    $campo = $_POST['campo'];
    $archivo = $_FILES['archivo'];

    try {
        $salidaInventario = new Salida(null, null, null, null);
        $rutaArchivo = '';
        if ($campo === 'evidencia') {
            $resultado = $salidaInventario->subirArchivoEvidencia($id_salida, $archivo);
            $rutaArchivo = "../Salida/evidencia/" . basename($archivo['name']);
        } elseif ($campo === 'documentacion') {
            $resultado = $salidaInventario->subirArchivoDocumentacion($id_salida, $archivo);
            $rutaArchivo = "../Salida/documentacion/" . basename($archivo['name']);
        } else {
            $resultado = "Campo no especificado.";
        }
        echo json_encode(['success' => true, 'campo' => $campo, 'ruta' => $rutaArchivo]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

// Obtener los datos de las salidas
$salidas = [];
try {
    $salidaInventario = new Salida(null, null, null, null);
    $salidas = json_decode($salidaInventario->obtenerSalidasConDetalles(), true)['salidas'];
} catch (Exception $e) {
    $error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario Salidas</title>
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
        <h1 class="mt-5 mb-3">Inventario de Salidas</h1>

        <div class="d-flex mb-3">
            <div>
                <a href="../Salida/Form_salida.php" class="btn btn-success mr-2">
                    <span class="me-2">+</span> Sacar Inventario
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
                        <th>Salida N°</th>
                        <th>Producto</th>
                        <th>Kilos</th>
                        <th>Fecha y Hora</th>
                        <th>Cliente</th>
                        <th>Usuario</th>
                        <th>Evidencia</th>
                        <th>Documentación</th>
                    </tr>
                </thead>
                <tbody id="data-table-body">
                    <?php if (!empty($salidas)): ?>
                        <?php foreach ($salidas as $salida): ?>
                            <?php
                                $iconoEvidencia = !empty($salida['evidencia']) ? '✔' : '✘';
                                $claseIconoEvidencia = !empty($salida['evidencia']) ? 'green' : 'red';
                                $iconoDocumentacion = !empty($salida['documentacion']) ? '✔' : '✘';
                                $claseIconoDocumentacion = !empty($salida['documentacion']) ? 'green' : 'red';
                            ?>
                            <tr id="salida-<?= htmlspecialchars($salida['id']) ?>">
                                <td><?= htmlspecialchars($salida['id']) ?></td>
                                <td><?= htmlspecialchars($salida['nombre_producto']) ?></td>
                                <td><?= htmlspecialchars($salida['suma_total_kilos']) ?></td>
                                <td><?= htmlspecialchars($salida['fecha_hora']) ?></td>
                                <td><?= htmlspecialchars($salida['nombre_cliente']) ?></td>
                                <td><?= htmlspecialchars($salida['nombre_usuario']) ?></td>
                                <td>
                                    <?php if (!empty($salida['evidencia'])): ?>
                                        <a href="<?= htmlspecialchars($salida['evidencia']) ?>" target="_blank" class="btn btn-primary">Ver Evidencia</a>
                                    <?php else: ?>
                                        <button class="btn btn-primary" onclick="uploadEvidencia(<?= htmlspecialchars($salida['id']) ?>)">
                                            Subir Evidencia
                                        </button>
                                    <?php endif; ?>
                                    <span id="icon-evidencia-<?= htmlspecialchars($salida['id']) ?>" class="status-icon <?= $claseIconoEvidencia ?>"><?= $iconoEvidencia ?></span>
                                </td>
                                <td>
                                    <?php if (!empty($salida['documentacion'])): ?>
                                        <a href="<?= htmlspecialchars($salida['documentacion']) ?>" target="_blank" class="btn btn-info">Ver Documentación</a>
                                    <?php else: ?>
                                        <button class="btn btn-info" onclick="uploadDocumentacion(<?= htmlspecialchars($salida['id']) ?>)">
                                            Subir Documentación
                                        </button>
                                    <?php endif; ?>
                                    <span id="icon-documentacion-<?= htmlspecialchars($salida['id']) ?>" class="status-icon <?= $claseIconoDocumentacion ?>"><?= $iconoDocumentacion ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8">No hay datos disponibles</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para subir evidencia -->
    <div id="evidenciaModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Subir Evidencia</h2>
            <form id="evidenciaForm" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_salida" id="evidenciaId">
                <input type="hidden" name="campo" value="evidencia">
                <div class="form-group">
                    <label for="archivoEvidencia">Archivo de Evidencia:</label>
                    <input type="file" name="archivo" id="archivoEvidencia" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Subir</button>
            </form>
        </div>
    </div>

    <!-- Modal para subir documentación -->
    <div id="documentacionModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Subir Documentación</h2>
            <form id="documentacionForm" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_salida" id="documentacionId">
                <input type="hidden" name="campo" value="documentacion">
                <div class="form-group">
                    <label for="archivoDocumentacion">Archivo de Documentación:</label>
                    <input type="file" name="archivo" id="archivoDocumentacion" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Subir</button>
            </form>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicialización de DataTable
            var table = $('#data-table').DataTable({
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
                "order": [[0, "desc"]],  // Ordenar por la primera columna (ID) en orden descendente
                initComplete: function() {
                    $('.dt-button').removeClass('dt-button').addClass('btn');
                }
            });

            // Selector de rango de fechas
            flatpickr("#dateRange", {
                mode: "range",
                dateFormat: "Y-m-d",
                onClose: function(selectedDates) {
                    table.draw();
                }
            });

            // Función para mostrar el modal de evidencia
            window.uploadEvidencia = function(id) {
                document.getElementById('evidenciaId').value = id;
                evidenciaModal.style.display = "block";
            };

            // Función para mostrar el modal de documentación
            window.uploadDocumentacion = function(id) {
                document.getElementById('documentacionId').value = id;
                documentacionModal.style.display = "block";
            };

            // Manejo del formulario de evidencia
            evidenciaForm.onsubmit = function(e) {
                e.preventDefault();
                const formData = new FormData(evidenciaForm);
                fetch('', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        let salidaId = document.getElementById('evidenciaId').value;
                        document.querySelector(`#salida-${salidaId} .btn-primary`).outerHTML = `<a href="${data.ruta}" target="_blank" class="btn btn-primary">Ver Evidencia</a>`;
                        document.getElementById(`icon-evidencia-${salidaId}`).textContent = '✔';
                        document.getElementById(`icon-evidencia-${salidaId}`).className = 'status-icon green';
                        evidenciaModal.style.display = "none";
                    } else {
                        alert('Error al subir la evidencia: ' + data.message);
                    }
                })
                .catch(error => console.error('Error al subir la evidencia:', error));
            };

            // Manejo del formulario de documentación
            documentacionForm.onsubmit = function(e) {
                e.preventDefault();
                const formData = new FormData(documentacionForm);
                fetch('', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        let salidaId = document.getElementById('documentacionId').value;
                        document.querySelector(`#salida-${salidaId} .btn-info`).outerHTML = `<a href="${data.ruta}" target="_blank" class="btn btn-info">Ver Documentación</a>`;
                        document.getElementById(`icon-documentacion-${salidaId}`).textContent = '✔';
                        document.getElementById(`icon-documentacion-${salidaId}`).className = 'status-icon green';
                        documentacionModal.style.display = "none";
                    } else {
                        alert('Error al subir la documentación: ' + data.message);
                    }
                })
                .catch(error => console.error('Error al subir la documentación:', error));
            };

            // Cerrar modales
            document.querySelectorAll('.close').forEach(btn => {
                btn.onclick = function() {
                    evidenciaModal.style.display = "none";
                    documentacionModal.style.display = "none";
                };
            });

            window.onclick = function(event) {
                if (event.target == evidenciaModal || event.target == documentacionModal) {
                    evidenciaModal.style.display = "none";
                    documentacionModal.style.display = "none";
                }
            };
        });
    </script>
</body>
</html>
