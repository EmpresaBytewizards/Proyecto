<?php
session_start();
require_once 'ConexionDB.php';

//Comprobar si un usuario existe en el arreglo
function existeUsuario($username, $password) {
    foreach ($_SESSION['users'] as $user) {
        if ($user['user'] === $username && password_verify($password, $user['password'])) {
            return true;
        }
    }
    return false;
}

//Agregar un usuario al arreglo global
function agregarUsuarios($usuarioId, $name, $email, $direction, $numero, $hashedPassword) {
    $_SESSION['usuarios'][] = [
        'id' => htmlspecialchars($usuarioId),
        'nombre' => htmlspecialchars($name),
        'correo' => htmlspecialchars($email),
        'direccion' => htmlspecialchars($direction),
        'numero' => htmlspecialchars($numero),
        'contraseña' => htmlspecialchars($hashedPassword)
    ];
}


//Cerrar sesión
function logout() {
    session_start();
    session_destroy();
    header("Location: ../interfaz/index.php");
    exit();
}

//Verificar si el usuario está logueado
function verificarSesion() {
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        exit();
    }
}
?>