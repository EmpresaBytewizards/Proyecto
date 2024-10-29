<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Permitir solicitudes de cualquier origen
header('Access-Control-Allow-Methods: GET, POST, PUT'); // Métodos HTTP permitidos
header('Access-Control-Allow-Headers: Content-Type'); // Encabezados permitidos
require("ConexionDB.php");
class ApiCarrito
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
            $stmt = $this->pdo->prepare("SELECT * FROM carrito WHERE id_carrito = ?");
            $stmt->execute([$id]);
            $carritos = $stmt->fetch(PDO::FETCH_ASSOC);
            return $carritos;
        } else {
            $stmt = $this->pdo->prepare("SELECT * FROM carrito");
            $stmt->execute();
            $carritos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $carritos;
        }
    }

    public function actualizar($id, $estado)
    {
        // Editar producto existente (UPDATE)
    $stmt = $this->pdo->prepare("UPDATE carrito SET estado = ? WHERE id_carrito = ?");

    // Ejecutar la consulta y devolver el resultado
    return $stmt->execute([$estado, $id]);
    }

}

//Configuracion de la base de datos
$host = 'localhost';
$dbname = 'weshop';
$username = 'root';
$password = '';

$conexionDB = new ConexionDB($host, $dbname, $username, $password);
$pdo = $conexionDB -> getPDO();
$carrito = new ApiCarrito($pdo);

// Manejo de solicitudes GET, POST, PUT y DELETE 
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $carritos = $carrito->obtenerTodos();
    echo json_encode($carritos);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos JSON del cuerpo de la solicitud
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    $id = isset($data['id']) ? $data['id'] : null;
    $estado = isset($data['estado']) ? $data['estado'] : null;

    $carrito->actualizar($id, $estado);
}

?>