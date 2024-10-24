<?php 
session_start(); 
if (!empty($_SESSION['empresas'])) {
    require("../API/ConexionDB.php");

    // Configuración de la base de datos
    $host = 'localhost';
    $dbname = 'weshop';
    $username = 'root';
    $password = ''; // Cambia la contraseña si es necesario

    $conexionDB = new ConexionDB($host, $dbname, $username, $password);
    $pdo = $conexionDB->getPDO();
    $stmt = $pdo->prepare("SELECT * FROM empresa WHERE id_empresa = ?");
    $stmt->execute([$_SESSION['empresas'][0]['id']]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    if($usuario){
        $_SESSION['empresas'][0] = [ 
            'id' => $usuario['id_empresa'],
            'nombre' => $usuario['nombre_empresa'],
            'correo' => $usuario['mail_empresa'],
            'direccion' => $usuario['ubicacion_fisica'],
            'numero' => $usuario['telefono_empresa'],
            'habilitacion' => $usuario['habilitacion_empresa']
        ];
    }
}
if (isset($_SESSION['empresas'])) {
    if ($_SESSION['empresas'][0]['habilitacion'] == "Habilitado"){
        header("Location: indexProveedores.php");
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
        <a href="http://localhost/bytewizards/API/sessionDestroyProv.php"> ¡Presione aquí si quieres intentar refrezcar su informacion e inciar sesion nuevamente! </a>
    </div>
</body>
</html>
