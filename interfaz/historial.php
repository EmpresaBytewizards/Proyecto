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

        // Consultar carritos del usuario
        $stmt = $pdo->prepare("SELECT * FROM carrito WHERE id_usu = ?");
        $stmt->execute([$id_usu]);
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
    <title>Historial</title>
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
    <div class="container">
        <h1>Historial de Compras</h1>

        <?php if (count($carritos) > 0): ?>
            <?php foreach ($carritos as $carrito): ?>
                <div class="carrito">
                    <h2>ID del Carrito: <?php echo htmlspecialchars($carrito['id_carrito']); ?></h2>
                    <p>Dirección de Envío: <?php echo htmlspecialchars($carrito['envio']); ?></p>
                    <p>Precio Total: <span class="precio"><?php echo htmlspecialchars($carrito['precio_carrito']); ?> €</span></p>

                    <?php
                    // Obtener artículos en el carrito
                    $stmt = $pdo->prepare("SELECT * FROM contiene WHERE id_carrito = ?");
                    $stmt->execute([$carrito['id_carrito']]);
                    $articulos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    ?>

                    <?php if (count($articulos) > 0): ?>
                        <?php foreach ($articulos as $articulo): ?>
                            <div class="articulo">
                                <strong>Nombre del producto:</strong> <?php echo htmlspecialchars($articulo['nombre_contiene']); ?><br>
                                <strong>Precio del producto:</strong> <?php echo htmlspecialchars($articulo['precio_contiene']); ?> €
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No hay artículos en este carrito.</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No tienes carritos de compras registrados.</p>
        <?php endif; ?>
    </div>
    </main>

</body>
</html>
