<?php 
session_start(); 
if (!empty($_SESSION['usuarios'])) {
    require("../API/ConexionDB.php");

    // Configuración de la base de datos
    $host = 'localhost';
    $dbname = 'weshop';
    $username = 'root';
    $password = ''; // Cambia la contraseña si es necesario

    $conexionDB = new ConexionDB($host, $dbname, $username, $password);
    $pdo = $conexionDB->getPDO();
    $stmt = $pdo->prepare("SELECT * FROM usuario WHERE id_usu = ?");
    $stmt->execute([$_SESSION['usuarios'][0]['id']]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    if($usuario){
        $_SESSION['usuarios'][0] = [ 
            'id' => $usuario['id_usu'],
            'nombre' => $usuario['nombre_usu'],
            'correo' => $usuario['mail_usu'],
            'direccion' => $usuario['direccion_usu'],
            'numero' => $usuario['telefono_usu'],
            'habilitacion' => $usuario['habilitacion_usu']
        ];
    }
}
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
        <p> Si desea habilitar su cuenta, puede contactarse con nosotros por correo a empresa.bytewizards.3bg@gmail.com </p>
        <a href="../API/sessionDestroy.php"> ¡Presione aquí si quieres intentar refrezcar su informacion e inciar sesion nuevamente! </a>
    </div>
</body>
</html>
