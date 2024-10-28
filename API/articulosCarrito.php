<?php
session_start(); // Inicia la sesión

// Asegúrate de que la solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos de la solicitud
    $data = json_decode(file_get_contents('php://input'), true);

    // Asegúrate de que los datos estén disponibles
    if (isset($data['items'])) {
        // Si ya hay items en la sesión, eliminarlos
        if (isset($_SESSION['cartItems'])) {
            unset($_SESSION['cartItems']);
        }
        
        // Guarda los nuevos items
        $_SESSION['cartItems'] = $data['items'];
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'No se recibieron datos.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Método no permitido.']);
}
?>
