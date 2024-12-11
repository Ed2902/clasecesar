<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Tickets</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/colreorder/1.5.2/css/colReorder.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>
    <div class="container-fluid" style="width: 90%;">
        <h1 class="mt-5 mb-3">Gestión de Tickets</h1>

        <div class="d-flex mb-3">
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
                        <th>Número de Ticket</th>
                        <th>Usuario</th>
                        <th>Descripción</th>
                        <th>Evidencia</th>
                        <th>Estado</th>
                        <th>Observación Usuario</th>
                        <th>Comentarios</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($tickets)): ?>
                        <?php foreach ($tickets as $ticket): ?>
                            <tr id="ticket-<?= htmlspecialchars($ticket['id']) ?>">
                                <td><?= htmlspecialchars($ticket['id']) ?></td>
                                <td><?= htmlspecialchars($ticket['usuario']) ?></td>
                                <td><?= htmlspecialchars($ticket['descripcion']) ?></td>
                                <td>
                                    <?php if (!empty($ticket['evidencia'])): ?>
                                        <a href="<?= htmlspecialchars($ticket['evidencia']) ?>" target="_blank" class="btn btn-primary">Ver Evidencia</a>
                                    <?php else: ?>
                                        <button class="btn btn-primary" onclick="uploadEvidencia(<?= htmlspecialchars($ticket['id']) ?>)">
                                            Subir Evidencia
                                        </button>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <select class="form-control" id="estado-<?= htmlspecialchars($ticket['id']) ?>">
                                        <option <?= $ticket['estado'] === 'No atendido' ? 'selected' : '' ?>>No atendido</option>
                                        <option <?= $ticket['estado'] === 'En proceso' ? 'selected' : '' ?>>En proceso</option>
                                        <option <?= $ticket['estado'] === 'Terminado' ? 'selected' : '' ?>>Terminado</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="observacion-<?= htmlspecialchars($ticket['id']) ?>" value="<?= htmlspecialchars($ticket['observacion']) ?>">
                                </td>
                                <td>
                                    <textarea class="form-control" id="comentarios-<?= htmlspecialchars($ticket['id']) ?>"><?= htmlspecialchars($ticket['comentarios']) ?></textarea>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">No hay datos disponibles</td>
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
                <input type="hidden" name="id_ticket" id="evidenciaId">
                <div class="form-group">
                    <label for="archivoEvidencia">Archivo de Evidencia:</label>
                    <input type="file" name="archivo" id="archivoEvidencia" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Subir</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/colReorder/1.5.2/js/dataTables.colReorder.min.js"></script>
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
                        let ticketId = document.getElementById('evidenciaId').value;
                        document.querySelector(`#ticket-${ticketId} .btn-primary`).outerHTML = `<a href="${data.ruta}" target="_blank" class="btn btn-primary">Ver Evidencia</a>`;
                        evidenciaModal.style.display = "none";
                    } else {
                        alert('Error al subir la evidencia: ' + data.message);
                    }
                })
                .catch(error => console.error('Error al subir la evidencia:', error));
            };

            // Cerrar modales
            document.querySelectorAll('.close').forEach(btn => {
                btn.onclick = function() {
                    evidenciaModal.style.display = "none";
                };
            });

            window.onclick = function(event) {
                if (event.target == evidenciaModal) {
                    evidenciaModal.style.display = "none";
                }
            };
        });
    </script>
</body>
</html>