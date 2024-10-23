<?php 
session_start(); 
if (isset($_SESSION['usuarios'])) {
    if ($_SESSION['usuarios'][0]['habilitacion'] == "Habilitado"){
        header("Location: index.php");
    }
}
?>
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
        <h2>Tu cuenta esta deshabilitada, no puedes acceder a la pagina mientras tu cuenta este deshabilitada.</h2>
        <a href="http://localhost/bytewizards/API/sessionDestroy.php"> ¡Presione aquí si quieres intentar refrezcar su informacion e inciar sesion nuevamente! </a>
    </div>
</body>
</html>
