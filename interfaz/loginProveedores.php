<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inicio sesion</title>
    <link rel="stylesheet" href="registerStyle.css">
</head>
<body>
    <header>
        <br>
        <img src="tienda/Logopagina tr borde.png" alt="Logo de We Shop" class="LogoWeShop">
        <br>
    </header>
    <div class="login-container">
        <h2>Iniciar Sesion</h2>
        <form id="formRegistro">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Iniciar Sesion</button>
            <p><a href="registerProv.php">¿Aun no tienes cuenta? ¡Clickea aquí!</a></p>
            <p><a href="index.php">¿Quieres iniciar como comprador? ¡Clickea aquí!</a></p>
            <p><a href="registerStaff.php">¿Trabajas aquí? ¡Presiona aquí!</a></p>
        </form>
    </div>
    <script src="loginProveedores.js"></script>
</body>
</html>
