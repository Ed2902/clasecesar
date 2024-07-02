<?php
include_once "../login/verificar_sesion.php";
require_once("./inventario.php");

// Verificar si se ha enviado el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idIngreso = $_POST['id_ingreso'];
    $id_productoFK = $_POST['id_producto'];
    $id_usuarioFK = $_POST['id_usuario'];
    $peso = $_POST['peso'];
    $id_proveedorFK = $_POST['id_proveedor'];
    $valorPorKilo = $_POST['valor_por_kilo'];

    $inventario = new Inventario(null, null, null, null, null);
    $resultado = $inventario->editar($idIngreso, $id_productoFK, $id_usuarioFK, $peso, $id_proveedorFK, $valorPorKilo);

    if ($resultado) {
        echo "Ingreso actualizado correctamente.";
    } else {
        echo "Error al actualizar el ingreso.";
    }
}

// Obtener detalles del ingreso para mostrar en el formulario
$idIngreso = $_GET['id'];
$inventario = new Inventario(null, null, null, null, null);
$detalleIngreso = $inventario->obtenerDetalleIngresosPorId($idIngreso);

if (!$detalleIngreso) {
    die("Error al obtener los detalles del ingreso.");
}
?>  
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Ingreso</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Agregar Font Awesome para los íconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Flecha hacia atrás -->
        <a href="javascript:history.back()" style="text-decoration: none;">
            <button type="button" class="btn btn-light mr-2" style="border-radius: 50%;">
                <i class="fas fa-arrow-left" style="font-size: 20px; color:#fe5000;"></i>
            </button>
        </a>
        <h1 class="mt-5 mb-3">Editar Ingreso</h1>
        <form method="POST">
            <input type="hidden" name="id_ingreso" value="<?php echo $detalleIngreso['id_ingreso']; ?>">
            <div class="form-group">
                <label for="id_producto">ID Producto</label>
                <input type="text" class="form-control" id="id_producto" name="id_producto" value="<?php echo $detalleIngreso['id_producto']; ?>">
            </div>
            <div class="form-group">
                <label for="id_usuario">ID Usuario</label>
                <input type="text" class="form-control" id="id_usuario" name="id_usuario" value="<?php echo $detalleIngreso['id_usuario']; ?>">
            </div>
            <div class="form-group">
                <label for="peso">Peso</label>
                <input type="text" class="form-control" id="peso" name="peso" value="<?php echo $detalleIngreso['peso']; ?>">
            </div>
            <div class="form-group">
                <label for="id_proveedor">ID Proveedor</label>
                <input type="text" class="form-control" id="id_proveedor" name="id_proveedor" value="<?php echo $detalleIngreso['id_proveedor']; ?>">
            </div>
            <div class="form-group">
                <label for="valor_por_kilo">Valor por Kilo</label>
                <input type="text" class="form-control" id="valor_por_kilo" name="valor_por_kilo" value="<?php echo $detalleIngreso['valor_por_kilo']; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
</body>
</html>
