<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Permitir solicitudes de cualquier origen
header('Access-Control-Allow-Methods: GET, POST, PUT'); // Métodos HTTP permitidos
header('Access-Control-Allow-Headers: Content-Type'); // Encabezados permitidos
require("ConexionDB.php");
session_start();

$stmt = $pdo->query("SELECT MAX(id_carrito) FROM carrito");
$ultimoIdCarrito = $stmt->fetchColumn();
$nuevoIdCarrito = $ultimoIdProducto ? $ultimoIdProducto + 1 : 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    

}

?>