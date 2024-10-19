<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Permitir solicitudes de cualquier origen
header('Access-Control-Allow-Methods: GET, POST, PUT'); // Métodos HTTP permitidos
header('Access-Control-Allow-Headers: Content-Type'); // Encabezados permitidos
require("ConexionDB.php");

$_SESSION['usuario']=[];

class ApiUsuarios
{
     
    function existeUsuario($email, $password) {
        foreach ($_SESSION['users'] as $user) {
            if ($user['user'] === $email && password_verify($password, $email['password'])) {
                return true;
            }
        }
        return false;
    }
function activarUsuario($username, $password){
if($username && $password ==true){
    session_start();

}

}

}

?>