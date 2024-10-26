<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Permitir solicitudes de cualquier origen
header('Access-Control-Allow-Methods: GET, POST, PUT'); // Métodos HTTP permitidos
header('Access-Control-Allow-Headers: Content-Type'); // Encabezados permitidos
require("ConexionDB.php");
class ApiUsuarios
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
            $stmt = $this->pdo->prepare("SELECT * FROM usuario WHERE id_usu = ?");
            $stmt->execute([$id]);
            $usuarios = $stmt->fetch(PDO::FETCH_ASSOC);
            return $usuarios;
        } else {
            $stmt = $this->pdo->prepare("SELECT * FROM usuario");
            $stmt->execute();
            $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $usuarios;
        }
    }

    public function actualizar($id, $estado)
    {

    $stmt = $this->pdo->prepare("UPDATE usuario SET habilitacion_usu = ? WHERE id_usu = ?");

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
$usuario = new ApiUsuarios($pdo);

// Manejo de solicitudes GET, POST, PUT y DELETE 
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $usuarios = $usuario->obtenerTodos();
    echo json_encode($usuarios);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos JSON del cuerpo de la solicitud
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    $id = isset($data['id']) ? $data['id'] : null;
    $estado = isset($data['estado']) ? $data['estado'] : null;

    $usuario->actualizar($id, $estado);
}

?>