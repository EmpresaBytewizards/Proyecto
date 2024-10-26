<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Permitir solicitudes de cualquier origen
header('Access-Control-Allow-Methods: GET, POST, PUT'); // Métodos HTTP permitidos
header('Access-Control-Allow-Headers: Content-Type'); // Encabezados permitidos
require("ConexionDB.php");
class ApiProveedores
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function obtenerTodos()
    {
        // Verifica si se ha proporcionado un ID
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $stmt = $this->pdo->prepare("SELECT * FROM empresa WHERE id_empresa = ?");
            $stmt->execute([$id]);
            $proveedores = $stmt->fetch(PDO::FETCH_ASSOC);
            return $proveedores;
        } else {
            $stmt = $this->pdo->prepare("SELECT * FROM empresa");
            $stmt->execute();
            $proveedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $proveedores;
        }
    }

}

//Configuracion de la base de datos
$host = 'localhost';
$dbname = 'weshop';
$username = 'root';
$password = '';

$conexionDB = new ConexionDB($host, $dbname, $username, $password);
$pdo = $conexionDB -> getPDO();
$proveedor = new ApiProveedores($pdo);

// Manejo de solicitudes GET, POST, PUT y DELETE 
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $proveedores = $proveedor->obtenerTodos();
    echo json_encode($proveedores);
}

?>