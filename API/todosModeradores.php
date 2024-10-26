<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Permitir solicitudes de cualquier origen
header('Access-Control-Allow-Methods: GET, POST, PUT'); // Métodos HTTP permitidos
header('Access-Control-Allow-Headers: Content-Type'); // Encabezados permitidos
require("ConexionDB.php");
class ApiStaff
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
            $stmt = $this->pdo->prepare("SELECT * FROM staff WHERE id_staff = ? AND tipo_staff = 'Moderador'");
            $stmt->execute([$id]);
            $staffs = $stmt->fetch(PDO::FETCH_ASSOC);
            return $staffs;
        } else {
            $stmt = $this->pdo->prepare("SELECT * FROM staff WHERE tipo_staff = 'Moderador' OR tipo_staff ='Deshabilitado'");
            $stmt->execute();
            $staffs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $staffs;
        }
    }

}

//Configuracion de la base de datos
$host = 'localhost';
$dbname = 'backoffice';
$username = 'root';
$password = '';

$conexionDB = new ConexionDB($host, $dbname, $username, $password);
$pdo = $conexionDB -> getPDO();
$staff = new ApiStaff($pdo);

// Manejo de solicitudes GET, POST, PUT y DELETE 
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $staffs = $staff->obtenerTodos();
    echo json_encode($staffs);
}

?>