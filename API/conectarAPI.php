<?php
$host = 'localhost';
$dbname = 'ecommerce_bd';
$username = 'root';
$password = '';
header('Content-Type: application/json');

header('Access-Control-Allow-Origin: *'); // Permitir solicitudes de cualquier origen
header('Access-Control-Allow-Methods: GET, POST'); // Métodos HTTP permitidos
header('Access-Control-Allow-Headers: Content-Type'); // Encabezados permitidos
//Conexion a la base de datos
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname",$username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 } catch (PDOException $e) {
    die("Error al conectar la base de datos: " . $e->getMessage());
} 



// Obtener todos los productos 
if($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $pdo->prepare("SELECT * FROM producto");
    $stmt->execute();
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($productos);
}
?>