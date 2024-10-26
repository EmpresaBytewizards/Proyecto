<?php 
session_start(); 
if (!empty($_SESSION['staffs'])) {
    require("../API/ConexionDB.php");

    // Configuración de la base de datos
    $host = 'localhost';
    $dbname = 'backoffice';
    $username = 'root';
    $password = ''; // Cambia la contraseña si es necesario

    $conexionDB = new ConexionDB($host, $dbname, $username, $password);
    $pdo = $conexionDB->getPDO();
    $stmt = $pdo->prepare("SELECT * FROM staff WHERE id_staff = ?");
    $stmt->execute([$_SESSION['staffs'][0]['id']]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    if($usuario){
        $_SESSION['staffs'][0] = [ 
            'id' => $usuario['id_staff'],
            'nombre' => $usuario['nombre_staff'],
            'correo' => $usuario['mail_staff'],
            'direccion' => $usuario['ubicacion_staff'],
            'numero' => $usuario['telefono_staff'],
            'tipo' => $usuario['tipo_staff']
        ];
    }
}
if (isset($_SESSION['staffs'])) {
    if ($_SESSION['staffs'][0]['tipo'] != "Deshabilitado"){
        header("Location: indexStaff.php");
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
        <a href="http://localhost/bytewizards/API/sessionDestroyStaff.php"> ¡Presione aquí si quieres intentar refrezcar su informacion e inciar sesion nuevamente! </a>
    </div>
</body>
</html>
