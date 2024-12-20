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
        <h2>Registrarse</h2>
        <form id="formRegistro">
            <label for="nombre">Nombre:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="direction">Direccion:</label>
            <input type="text" id="direction" name="direction" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="numero">Número de Telefono:</label>
            <input type="number" id="numero" name="numero" required>

            <label for="password">Contraseña:</label>
            <ul class="required">
                <li id="caractMin" class="reject"> Minímo 5 caracteres. </li>
                <li id="mayMin" class="reject"> Minímo 1 letra mayuscula. </li>
                <li id="minMin" class="reject"> Minímo 1 letra minuscula. </li>
                <li id="minNum" class="reject"> Al menos 1 número. </li>
            </ul>
            <input type="password" id="password" name="password" required>
            <label for="password">Repita su contraseña:</label>
            <input type="password" id="password2" name="password2" required>
            <p> ¡No se registre si no tiene un contrato de trabajo con nosotros! </p>
            <button type="submit">Registrarse</button>
            <h5> En caso de que no funcione, intente poner otro nombre </h5>
            <p><a href="index.php">¿Quieres volver a la pagina principal? ¡Clickea aquí!</a></p>
            <p><a href="loginStaff.php">¿Ya tienes una cuenta? ¡Clickea aquí!</a></p>
        </form>
    </div>
    <script src="registerStaff.js"></script>
</body>
</html>
