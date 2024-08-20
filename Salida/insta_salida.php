<?php
// Incluir las clases y verificar la sesión
include_once "../login/verificar_sesion.php";
require_once("./class_salida.php");

// Verificar si se ha recibido el JSON en la solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el JSON desde la solicitud
    $jsonData = file_get_contents('php://input');
    
    if ($jsonData) {
        // Instanciar la clase Salida
        $salida = new Salida(0, 0, 0, 0); // Los valores iniciales no importan para este método
        
        // Pasar el JSON al método para procesarlo
        $resultado = $salida->registrarSalidaDesdeJson($jsonData);
        
        if ($resultado) {
            // Devolver una respuesta exitosa
            echo json_encode(['success' => true]);
        } else {
            // Devolver una respuesta de error
            echo json_encode(['success' => false, 'message' => 'Error al registrar la salida en la base de datos.']);
        }
    } else {
        // Devolver una respuesta de error si no se recibe JSON
        echo json_encode(['success' => false, 'message' => 'No se recibieron datos válidos.']);
    }
} else {
    // Devolver una respuesta de error si el método de solicitud no es POST
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}
?>
