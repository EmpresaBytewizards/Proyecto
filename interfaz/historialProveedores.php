<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
if (empty($_SESSION['empresas'])) {
    header("Location: loginProveedores.php");
}
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
    if (isset($_SESSION['empresas']) && !empty($_SESSION['empresas'])) {
        $id_usu = $_SESSION['empresas'][0]['id'];

        // Consultar carritos del usuario
        $stmt = $pdo->prepare("SELECT * FROM contiene WHERE id_empresa_contiene = ?");
        $stmt->execute([$id_usu]);
        $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $ventas = [];
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
    <p><a href='indexProveedores.php' style='color: #1900ff;'>¿Desea volver a la pagina principal? ¡Presiona aquí!</a></p>
    <div class="container">
        <h1>Historial de Ventas</h1>
        <span> Si desea discutir una venta, contactese por correo a empresa.bytewizards.3bg@gmail.com adjuntando el id del pedido, motivo e id de usuario de ustedes(consultar en su perfil). </span>

        <?php if (count($ventas) > 0): ?>
            <?php foreach ($ventas as $venta): ?>
                <div class="carrito">
                    <h2>ID de la venta: <?php echo htmlspecialchars($venta['id_contiene']); ?></h2>
                    <p>ID del producto: <?php echo htmlspecialchars($venta['id_producto_contiene']); ?></p>
                    <p>Nombre del producto: <span class="nombre"><?php echo htmlspecialchars($venta['nombre_contiene']); ?></span></p>
                    <p>Precio Total: <span class="precio"><?php echo htmlspecialchars($venta['precio_contiene']); ?> $</span></p>
                    <p>Fecha: <span class="fecha"><?php echo htmlspecialchars($venta['fecha_contiene']); ?></span></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No tienes ventas registradas.</p>
        <?php endif; ?>
    </div>
    </main>

</body>
</html>
