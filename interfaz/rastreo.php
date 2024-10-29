<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

// Configuración de la base de datos
$host = 'localhost';
$dbname = 'weshop';
$username = 'root';
$password = '';

try {
    // Crear la conexión PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Manejo de errores
    // Obtener el ID del usuario de la sesión
    if (isset($_SESSION['usuarios']) && !empty($_SESSION['usuarios'])) {
        $id_usu = $_SESSION['usuarios'][0]['id'];
        if (isset($_GET['idCarrito'])) {
            $idCarrito = $_GET['idCarrito'];
        } else {
            echo "idCarrito no está definido en la URL.";
        }
        // Consultar carritos del usuario
        $stmt = $pdo->prepare("SELECT * FROM carrito WHERE id_usu = ? AND id_carrito = ?");
        $stmt->execute([$id_usu, $idCarrito]);
        $carritos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $carritos = [];
    }
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rastreo</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="stylesHistorial.css">
</head>
<body>
    <header> 
        <div class="header__top">
            <div class="logo__container">
                <img id="logo_pagina" src="tienda/Logopagina tr borde.png" data-category="CATALOG">
            </div>
            <nav style="display:flex;justify-content: end;">
            </nav>
        </div>
        <div class="blackbar"> ENVÍO Y DEVOLUCIONES GRATIS </div>
    </header>
    <main>
    <p><a href='index.php' style='color: #1900ff;'>¿Desea volver a la pagina principal? ¡Presiona aquí!</a></p>

    <?php
    if (!empty($carritos)) {
        $carrito = $carritos[0]; // Tomar el primer carrito

        if ($carrito['estado'] == 'empaquetando') { ?> 
            <img src="tienda/archivos/gif/1.gif" alt="empaquetando">
            <h1> Empaquetando el pedido. </h1>    
        <?php } elseif ($carrito['estado'] == 'en_camino') { ?>
            <img src="tienda/archivos/gif/2.gif" alt="enviado">
            <h1> Enviando el pedido. </h1>
        <?php } elseif ($carrito['estado'] == 'entregado') { ?>
            <img src="tienda/archivos/gif/3.gif" alt="entregado">
            <h1> El pedido ha sido entregado. </h1>
        <?php } elseif ($carrito['estado'] == 'empaquetando_devolucion') { ?>
            <img src="tienda/archivos/gif/1invertido.gif" alt="recuperando">
            <h1> Recuperando el pedido. </h1>
        <?php } elseif ($carrito['estado'] == 'enviado_devolucion') { ?>
            <img src="tienda/archivos/gif/2invertido.gif" alt="recuperandoEnvio">
            <h1> Enviado el pedido de regreso. </h1>
        <?php } elseif ($carrito['estado'] == 'entregado_devolucion') { ?>
            <img src="tienda/archivos/gif/3invertido.gif" alt="recuperado">
            <h1> El pedido ha sido recuperado con éxito. </h1>
        <?php }
    } else {
        echo "<p>No se encontró el carrito.</p>";
    }
    ?>
    </main>
</body>
</html>
