<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Permitir solicitudes de cualquier origen
header('Access-Control-Allow-Methods: GET, POST, PUT'); // Métodos HTTP permitidos
header('Access-Control-Allow-Headers: Content-Type'); // Encabezados permitidos
require("ConexionDB.php");
class ApiDenuncia
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
            $stmt = $this->pdo->prepare("SELECT * FROM denuncia WHERE id_denuncia = ?");
            $stmt->execute([$id]);
            $denuncias = $stmt->fetch(PDO::FETCH_ASSOC);
            return $denuncias;
        } else {
            $stmt = $this->pdo->prepare("SELECT * FROM denuncia");
            $stmt->execute();
            $denuncias = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $denuncias;
        }
    }

    public function actualizar($id, $estado)
    {
        // Editar producto existente (UPDATE)
    $stmt = $this->pdo->prepare("UPDATE denuncia SET estado_denuncia = ? WHERE id_denuncia = ?");

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
$denuncia = new ApiDenuncia($pdo);

// Manejo de solicitudes GET, POST, PUT y DELETE 
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $denuncias = $denuncia->obtenerTodos();
    echo json_encode($denuncias);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos JSON del cuerpo de la solicitud
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    $id = isset($data['id']) ? $data['id'] : null;
    $estado = isset($data['estado']) ? $data['estado'] : null;

    $denuncia->actualizar($id, $estado);
}

?>