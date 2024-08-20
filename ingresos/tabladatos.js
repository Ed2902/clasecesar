document.addEventListener('DOMContentLoaded', function() {
    // Inicializar DataTable
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
        initComplete: function() {
            // Aplicar clases de Bootstrap a los botones después de la inicialización
            $('.dt-button').removeClass('dt-button').addClass('btn');
        }
    });

    // Inicializar el selector de rango de fechas con flatpickr
    flatpickr("#dateRange", {
        mode: "range",
        dateFormat: "Y-m-d",
        onClose: function(selectedDates) {
            table.draw();
        }
    });

    // Añadir filtro de fecha personalizado
    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        var dateRange = document.getElementById('dateRange')._flatpickr.selectedDates;
        if (!dateRange.length) return true;

        var startDate = dateRange[0];
        var endDate = dateRange[1];
        var date = new Date(data[1]); // Convertir la fecha de la columna a un objeto Date

        // Asegurarse de que las fechas estén en el formato correcto
        if (startDate) {
            startDate.setHours(0, 0, 0, 0); // Asegurarse de que la hora es 00:00:00
        }
        if (endDate) {
            endDate.setHours(23, 59, 59, 999); // Asegurarse de que la hora es 23:59:59
        }

        // Verificar si la fila debe ser visible según el rango de fechas
        if (
            (!startDate && !endDate) || // Ambos campos de fecha vacíos
            (!startDate && date <= endDate) || // Solo fecha de fin definida
            (startDate <= date && !endDate) || // Solo fecha de inicio definida
            (startDate <= date && date <= endDate) // Ambos campos de fecha definidos y fecha dentro del rango
        ) {
            return true;
        }
        return false;
    });

    // Hacer las columnas de la tabla redimensionables
    $('#data-table th').each(function() {
        $(this).resizable({
            handles: "e",
            alsoResize: "td",
            stop: function(e, ui) {
                var sizerID = ui.helper.attr("id");
                var sizerWidth = ui.size.width;
                table.columns().every(function() {
                    var colHeader = $(this.header());
                    if (colHeader.attr("id") === sizerID) {
                        this.width(sizerWidth);
                    }
                });
            }
        });
    });
});

function showDocuments(id) {
    fetch(`?documentos_id=${id}`)
        .then(response => response.json())
        .then(documentos => {
            const modal = document.getElementById('detailModal');
            const modalBody = document.getElementById('modal-body');

            let documentosHtml = `
                <h2>Documentos de Ingreso ${id}</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tipo de Documento</th>
                            <th>Archivo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Factura</td>
                            <td>${documentos.factura ? `<a href="${documentos.factura}" target="_blank">Ver documento</a>` : '<input type="file" name="archivo_factura_' + id + '" /><button class="btn btn-success" onclick="saveFile(' + id + ', \'factura\')">Guardar</button>'}</td>
                            <td>${documentos.factura ? '<button class="btn btn-warning" onclick="editDocument(' + id + ', \'factura\')">Editar</button>' : ''}</td>
                        </tr>
                        <tr>
                            <td>Orden de Compra</td>
                            <td>${documentos.ordenCompra ? `<a href="${documentos.ordenCompra}" target="_blank">Ver documento</a>` : '<input type="file" name="archivo_ordenCompra_' + id + '" /><button class="btn btn-success" onclick="saveFile(' + id + ', \'ordenCompra\')">Guardar</button>'}</td>
                            <td>${documentos.ordenCompra ? '<button class="btn btn-warning" onclick="editDocument(' + id + ', \'ordenCompra\')">Editar</button>' : ''}</td>
                        </tr>
                        <tr>
                            <td>Recibo de Pago</td>
                            <td>${documentos.reciboPago ? `<a href="${documentos.reciboPago}" target="_blank">Ver documento</a>` : '<input type="file" name="archivo_reciboPago_' + id + '" /><button class="btn btn-success" onclick="saveFile(' + id + ', \'reciboPago\')">Guardar</button>'}</td>
                            <td>${documentos.reciboPago ? '<button class="btn btn-warning" onclick="editDocument(' + id + ', \'reciboPago\')">Editar</button>' : ''}</td>
                        </tr>
                    </tbody>
                </table>
            `;

            modalBody.innerHTML = documentosHtml;
            modal.style.display = "block";
        })
        .catch(error => {
            console.error('Error al obtener los documentos:', error);
        });
}

function showDetails(id) {
    fetch(`?detalle_id=${id}`)
        .then(response => response.json())
        .then(detalles => {
            const modal = document.getElementById('detailsModal');
            const modalBody = document.getElementById('modal-body-detail');

            let detalleHtml = `
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID Ingreso</th>
                            <th>Fecha Ingreso</th>
                            <th>ID Producto</th>
                            <th>Nombre Producto</th>
                            <th>Peso</th>
                            <th>Valor por Kilo</th>
                            <th>Nombre Usuario</th>
                            <th>Nombre Proveedor</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            detalles.forEach(detalle => {
                detalleHtml += `
                    <tr>
                        <td>${detalle.id_ingreso}</td>
                        <td>${detalle.fecha_ingreso}</td>
                        <td>${detalle.id_producto}</td>
                        <td>${detalle.nombre_producto}</td>
                        <td>${detalle.peso}</td>
                        <td>${detalle.valor_por_kilo}</td>
                        <td>${detalle.nombre_usuario}</td>
                        <td>${detalle.nombre_proveedor}</td>
                    </tr>
                `;
            });

            detalleHtml += `
                    </tbody>
                </table>
            `;

            modalBody.innerHTML = detalleHtml;
            modal.style.display = "block";
        })
        .catch(error => {
            console.error('Error al obtener los detalles:', error);
        });
}

function saveFile(id, campo) {
    const input = document.querySelector(`input[name="archivo_${campo}_${id}"]`);

    if (input && input.files.length > 0) {
        const file = input.files[0];
        uploadFile(id, file, campo);
    }
}

function uploadFile(id, file, campo) {
    const formData = new FormData();
    formData.append('id', id);
    formData.append('campo', campo);
    formData.append('archivo', file);

    fetch('', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
        showDocuments(id); // Recargar el contenido del modal de documentos
    })
    .catch(error => {
        console.error('Error al subir el archivo:', error);
    });
}

function editDocument(id, campo) {
    const cell = document.querySelector(`td:contains('${campo}')`).parentNode;
    cell.innerHTML = `
        <input type="file" name="archivo_${campo}_${id}" class="form-control-file" />
        <button class="btn btn-success mt-2" onclick="saveFile(${id}, '${campo}')">Guardar</button>
    `;
}

const detailModal = document.getElementById('detailModal');
const detailsModal = document.getElementById('detailsModal');
const closeDetailModal = document.getElementsByClassName("close")[0];
const closeDetailsModal = document.getElementsByClassName("close")[1];

closeDetailModal.onclick = function() {
    detailModal.style.display = "none";
    location.reload(); // Recargar la página principal al cerrar el modal
}

closeDetailsModal.onclick = function() {
    detailsModal.style.display = "none";
    location.reload(); // Recargar la página principal al cerrar el modal
}

window.onclick = function(event) {
    if (event.target == detailModal || event.target == detailsModal) {
        detailModal.style.display = "none";
        detailsModal.style.display = "none";
        location.reload(); // Recargar la página principal al cerrar el modal
    }
}
