<?php 
include_once "../login/verificar_sesion.php";
require_once("./class_salida.php"); 

// Verificar si una sesión ya está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$user_id = $_SESSION['id_usuario'] ?? null;

// Instanciar la clase Salida para obtener los productos y clientes
$salida = new Salida(0, 0, 0, 0); // Los valores aquí no importan para este método
$productosJson = $salida->obtenerProductos();
$productos = json_decode($productosJson, true);

$clientesJson = $salida->obtenerClientes();
$clientes = json_decode($clientesJson, true);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dar salida de inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/styles.css">

    <!-- Estilos personalizados para el resplandor y el botón -->
    <style>
        

        /* Estilo para el botón "Sacar" en rojo */
        .boton_enviar {
            background-color: #ff4c4c;
            border: none;
            color: white;
            font-size: 1.2rem;
            padding: 10px 20px;
            border-radius: 10px;
            transition: background-color 0.3s ease;
        }

        .boton_enviar:hover {
            background-color: #ff4c4c;
        }

        /* Asegurar que el modal se muestre por encima de todo */
        .modal-backdrop {
            z-index: 1050; /* Debe estar por encima de otros elementos */
        }

        .modal {
            z-index: 1060; /* Asegúrate de que el modal esté por encima del backdrop */
        }

        /* Esto asegura que el contenido del modal esté bien centrado y visible */
        .modal-dialog-centered {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh; /* Esto asegura que el modal esté centrado verticalmente */
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-1 d-none d-sm-block">
                <a href="javascript:history.back()" class="btn-link fasbtn btn-link mt-2 ml-2">
                    <i class="fas fa-arrow-left" style="color: red;"></i>
                </a>
            </div>
            <div class="col-11">
                <div class="row justify-content-center">
                    <div class="col-md-9">
                        <form id="formularioInventario" class="form text-center border border-light p-3 shadow-lg rounded-lg">
                            <p class="h2 mb-4">Hacer salida</p>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="id_productoFK" class="form-label">Código Producto</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="id_productoFK" name="id_productoFK" placeholder="Código Producto">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#productModal">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" disabled>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="referencia" class="form-label">Referencia</label>
                                    <input type="text" class="form-control" id="referencia" name="referencia" placeholder="Referencia" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label for="tipo" class="form-label">Tipo</label>
                                    <input type="text" class="form-control" id="tipo" name="tipo" placeholder="Tipo" disabled>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="id_usuarioFK" class="form-label">Quién da la salida</label>
                                    <input type="number" class="form-control" id="id_usuarioFK" name="id_usuarioFK" value="<?php echo $user_id; ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="peso" class="form-label">Peso a Sacar (kg)</label>
                                    <input type="number" class="form-control" id="peso" name="peso" placeholder="Peso a Sacar (kg)">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="id_clienteFK" class="form-label">Cliente</label>
                                    <select id="id_clienteFK" name="id_clienteFK" class="form-control">
                                        <?php if ($clientes['success']): ?>
                                            <?php foreach ($clientes['clientes'] as $cliente): ?>
                                                <option value="<?php echo $cliente['id_cliente']; ?>"><?php echo $cliente['nombre']; ?></option>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option value="">Error al obtener los clientes</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <button type="button" id="agregar" class="boton_agregar btn btn-info btn-lg">Agregar</button>
                        </form>
                        <input type="hidden" id="RowIndex" name="RowIndex" value="">
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-9 mx-auto">
                        <div class="table-responsive">
                            <table class="table" id="lista">
                                <thead>
                                    <tr>
                                        <th>Código Producto</th>
                                        <th>Nombre</th>
                                        <th>Referencia</th>
                                        <th>Tipo</th>
                                        <th>Quién da la Salida</th>
                                        <th>Peso</th>
                                        <th>Cliente</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Aquí se agregarán dinámicamente las filas -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="totalsuma col-10 text-right" id="total"></div>
                <div class="row mt-4">
                    <div class="col-md-9 mx-auto text-center">
                        <button type="button" id="guardar" class="boton_enviar btn btn-lg">Hacer salida</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Seleccionar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Código Producto</th>
                                <th>Nombre</th>
                                <th>Referencia</th>
                                <th>Tipo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="productTableBody">
                            <?php if ($productos['success']): ?>
                                <?php foreach ($productos['productos'] as $producto): ?>
                                    <tr>
                                        <td><?php echo $producto['id_producto']; ?></td>
                                        <td><?php echo $producto['nombre']; ?></td>
                                        <td><?php echo $producto['referencia']; ?></td>
                                        <td><?php echo $producto['tipo']; ?></td>
                                        <td><button type="button" class="btn btn-primary select-product" data-id="<?php echo $producto['id_producto']; ?>" data-nombre="<?php echo $producto['nombre']; ?>" data-referencia="<?php echo $producto['referencia']; ?>" data-tipo="<?php echo $producto['tipo']; ?>">Seleccionar</button></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5">No se pudieron obtener los productos. Error: <?php echo $productos['message']; ?></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="./salida.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productos = <?php echo $productosJson; ?>;

            // Capturar el evento de presionar "Enter" en el campo "Código Producto"
            document.getElementById('id_productoFK').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault(); // Prevenir el comportamiento por defecto del "Enter"
                    const idProducto = this.value.trim(); // Obtener el valor y eliminar espacios en blanco

                    // Buscar el producto en la lista de productos, comparando como string y como número
                    const producto = productos.productos.find(p => p.id_producto.toString() === idProducto || p.id_producto === parseInt(idProducto));

                    if (producto) {
                        // Llenar los campos de nombre, referencia y tipo
                        document.getElementById('nombre').value = producto.nombre;
                        document.getElementById('referencia').value = producto.referencia;
                        document.getElementById('tipo').value = producto.tipo;
                    } else {
                        alert('Producto no encontrado');
                    }
                }
            });

            // Adjuntar eventos a los botones de selección de productos
            document.querySelectorAll('.select-product').forEach(button => {
                button.addEventListener('click', function() {
                    var idProducto = this.getAttribute('data-id');
                    var nombre = this.getAttribute('data-nombre');
                    var referencia = this.getAttribute('data-referencia');
                    var tipo = this.getAttribute('data-tipo');
                    
                    // Colocar los valores en el formulario
                    document.getElementById('id_productoFK').value = idProducto;
                    document.getElementById('nombre').value = nombre;
                    document.getElementById('referencia').value = referencia;
                    document.getElementById('tipo').value = tipo;

                    // Cerrar el modal
                    var modalElement = document.getElementById('productModal');
                    var modal = bootstrap.Modal.getInstance(modalElement);
                    modal.hide();
                });
            });
        });
    </script>
</body>
</html>
