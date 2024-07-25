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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Datos</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1; 
            padding-top: 60px; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgb(0,0,0); 
            background-color: rgba(0,0,0,0.4); 
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto; 
            padding: 20px;
            border: 1px solid #888;
            width: 80%; 
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Fecha y Hora</th>
            <th>Suma Total Kilos</th>
            <th>Factura</th>
            <th>Orden de Compra</th>
            <th>Recibo de Pago</th>
            <th>Detalle</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody id="data-table">
        <?php if (!empty($ingresos)): ?>
            <?php foreach ($ingresos as $ingreso): ?>
                <tr>
                    <td><?= htmlspecialchars($ingreso['id']) ?></td>
                    <td><?= htmlspecialchars($ingreso['fecha_hora']) ?></td>
                    <td><?= htmlspecialchars($ingreso['suma_total_kilos']) ?></td>
                    <td>
                        <?php if ($ingreso['factura']): ?>
                            <a href="<?= htmlspecialchars($ingreso['factura']) ?>" target="_blank">Ver documento</a>
                        <?php else: ?>
                            <input type="file" name="archivo_factura_<?= htmlspecialchars($ingreso['id']) ?>" />
                            <button onclick="saveFile(<?= htmlspecialchars($ingreso['id']) ?>, 'archivo_factura')">Guardar</button>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($ingreso['ordenCompra']): ?>
                            <a href="<?= htmlspecialchars($ingreso['ordenCompra']) ?>" target="_blank">Ver documento</a>
                        <?php else: ?>
                            <input type="file" name="archivo_ordenCompra_<?= htmlspecialchars($ingreso['id']) ?>" />
                            <button onclick="saveFile(<?= htmlspecialchars($ingreso['id']) ?>, 'archivo_ordenCompra')">Guardar</button>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($ingreso['reciboPago']): ?>
                            <a href="<?= htmlspecialchars($ingreso['reciboPago']) ?>" target="_blank">Ver documento</a>
                        <?php else: ?>
                            <input type="file" name="archivo_reciboPago_<?= htmlspecialchars($ingreso['id']) ?>" />
                            <button onclick="saveFile(<?= htmlspecialchars($ingreso['id']) ?>, 'archivo_reciboPago')">Guardar</button>
                        <?php endif; ?>
                    </td>
                    <td><button onclick="showDetails(<?= htmlspecialchars($ingreso['id']) ?>)">Detalle</button></td>
                    <td><button onclick="editData(<?= htmlspecialchars($ingreso['id']) ?>)">Editar</button></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8">No hay datos disponibles</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Modal -->
<div id="detailModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div id="modal-body">
            <!-- Contenido relacionado al ID se mostrará aquí -->
        </div>
    </div>
</div>

<script>
    const data = <?php echo json_encode($ingresos); ?>;
    const detalleData = {}; // Objeto de datos detallados vacío para ser llenado desde el backend

    const tableBody = document.getElementById('data-table');

    function populateTable() {
        tableBody.innerHTML = ''; // Limpiar la tabla antes de poblarla

        data.forEach(item => {
            const row = document.createElement('tr');

            row.innerHTML = `
                <td>${item.id}</td>
                <td>${item.fecha_hora}</td>
                <td>${item.suma_total_kilos}</td>
                <td>${item.factura ? `<a href="${item.factura}" target="_blank">Ver documento</a>` : '<input type="file" name="archivo_factura_' + item.id + '" /><button onclick="saveFile(' + item.id + ', \'factura\')">Guardar</button>'}</td>
                <td>${item.ordenCompra ? `<a href="${item.ordenCompra}" target="_blank">Ver documento</a>` : '<input type="file" name="archivo_ordenCompra_' + item.id + '" /><button onclick="saveFile(' + item.id + ', \'ordenCompra\')">Guardar</button>'}</td>
                <td>${item.reciboPago ? `<a href="${item.reciboPago}" target="_blank">Ver documento</a>` : '<input type="file" name="archivo_reciboPago_' + item.id + '" /><button onclick="saveFile(' + item.id + ', \'reciboPago\')">Guardar</button>'}</td>
                <td><button onclick="showDetails(${item.id})">Detalle</button></td>
                <td><button onclick="editData(${item.id})">Editar</button></td>
            `;

            tableBody.appendChild(row);
        });
    }

    function showDetails(id) {
        fetch(`?detalle_id=${id}`)
            .then(response => response.json())
            .then(detalles => {
                const modal = document.getElementById('detailModal');
                const modalBody = document.getElementById('modal-body');

                let detalleHtml = `
                    <table>
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

    function editData(id) {
        // Lógica para editar los datos
        alert(`Editar datos del ID: ${id}`);
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
            // Recargar la página para mostrar los cambios
            location.reload();
        })
        .catch(error => {
            console.error('Error al subir el archivo:', error);
        });
    }

    // Cerrar el modal
    const modal = document.getElementById('detailModal');
    const span = document.getElementsByClassName("close")[0];

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Poblar la tabla al cargar la página
    populateTable();
</script>

</body>
</html>
