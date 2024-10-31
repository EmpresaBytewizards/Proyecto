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
            
            // Obtener id_empresa del producto
            $stmtEmpresa = $pdo->prepare("SELECT id_empresa_producto FROM producto WHERE id_producto = ?");
            $stmtEmpresa->execute([$id_producto]);
            $id_empresa = $stmtEmpresa->fetchColumn();
            
            // Insertar en la tabla 'contiene'
            $stmt = $pdo->prepare("INSERT INTO contiene (id_producto, id_carrito, precio_contiene, nombre_contiene, id_empresa) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$id_producto, $nuevoIdCarrito, $precio_contiene, $nombre_contiene, $id_empresa]);
            
            // Obtener el stock actual del producto
            $stmtEmpresa = $pdo->prepare("SELECT stock FROM producto WHERE id_producto = ?");
            $stmtEmpresa->execute([$id_producto]);
            $stock_producto = $stmtEmpresa->fetchColumn();
            
            // Calcular el nuevo stock
            $stock_nuevo = $stock_producto - 1;
            
            // Actualizar el stock en la tabla 'producto'
            $stmt = $pdo->prepare("UPDATE producto SET stock = ? WHERE id_producto = ?");
            $stmt->execute([$stock_nuevo, $id_producto]);
        }        
        $emailSender = new EmailSender();
        $emailSender->setFrom('empresa.bytewizards.3bg@gmail.com', 'ByteWizards');
        $emailSender->addRecipient($_SESSION['usuarios'][0]['correo'], $_SESSION['usuarios'][0]['nombre']);
        // paymentId=$paymentId&payerId=$payerId
        $result = $emailSender->sendEmail('Rastreo de su pedido', 'Este es el enlace para el rastreo de su paquete: http://localhost/bytewizards/interfaz/rastreo.php?idCarrito=' . $nuevoIdCarrito);
        echo $result;
        // Responder con éxito
        echo json_encode(['success' => true, 'message' => 'Carrito y artículos guardados correctamente.']);
    } else {
        echo json_encode(['success' => false, 'error' => 'No hay items en el carrito.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Error de conexión: ' . $e->getMessage()]);
}
?>
