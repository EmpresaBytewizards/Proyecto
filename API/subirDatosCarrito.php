<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT');
header('Access-Control-Allow-Headers: Content-Type');

// Configuración de la base de datos
$host = 'localhost';
$dbname = 'weshop';
$username = 'root';
$password = '';

try {
    // Crear la conexión PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Manejo de errores

    session_start();

    // Obtener el nuevo ID del carrito
    $stmt = $pdo->query("SELECT MAX(id_carrito) FROM carrito");
    $ultimoIdCarrito = $stmt->fetchColumn();
    $nuevoIdCarrito = $ultimoIdCarrito ? $ultimoIdCarrito + 1 : 1;

    // Comprobar si hay items en la sesión
    if (isset($_SESSION['cartItems'])) {
        $cartItems = $_SESSION['cartItems'];
        
        // Sumar los precios de los productos en el carrito
        $precioCarrito = 0;
        foreach ($cartItems as $item) {
            $precioCarrito += $item['precio_base'];
        }

        // Obtener datos del usuario
        $envio = $_SESSION['usuarios'][0]['direccion'];
        $id_usu = $_SESSION['usuarios'][0]['id'];

        // Insertar en la tabla carrito
        $stmt = $pdo->prepare("INSERT INTO carrito (id_carrito, envio, id_usu, precio_carrito) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nuevoIdCarrito, $envio, $id_usu, $precioCarrito]);

        // Insertar cada artículo en la base de datos
        foreach ($cartItems as $item) {
            $id_producto = $item['id_producto'];
            $precio_contiene = $item['precio_base'];
            $nombre_contiene = $item['titulo'];

            $stmt = $pdo->prepare("INSERT INTO contiene (id_producto, id_carrito, precio_contiene, nombre_contiene) VALUES (?, ?, ?, ?)");
            $stmt->execute([$id_producto, $nuevoIdCarrito, $precio_contiene, $nombre_contiene]);
        }

        // Responder con éxito
        echo json_encode(['success' => true, 'message' => 'Carrito y artículos guardados correctamente.']);
    } else {
        echo json_encode(['success' => false, 'error' => 'No hay items en el carrito.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Error de conexión: ' . $e->getMessage()]);
}
?>
