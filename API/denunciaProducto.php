<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Permitir solicitudes de cualquier origen
header('Access-Control-Allow-Methods: GET, POST, PUT'); // Métodos HTTP permitidos
header('Access-Control-Allow-Headers: Content-Type'); // Encabezados permitidos
require("ConexionDB.php"); 
session_start();

class ApiDenuncia
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function agregarDenuncia($idDenunciado, $idDenunciante)
    {
        // Preparar la consulta
        $stmt = $this->pdo->prepare("INSERT INTO denuncia (id_denunciante, id_denunciado) VALUES (?, ?)");

        // Ejecutar la consulta
        if ($stmt->execute([$idDenunciante, $idDenunciado])) {
            echo json_encode(['message' => 'Denuncia enviada con éxito.']);
        } else {
            echo json_encode(['error' => 'Error al enviar denuncia', 'info' => $stmt->errorInfo()]);
        }
    }
}

// Configuración de la base de datos
$host = 'localhost';
$dbname = 'weshop';
$username = 'root';
$password = '';

$conexionDB = new ConexionDB($host, $dbname, $username, $password);
$pdo = $conexionDB->getPDO();

// Crear la instancia de la clase ApiDenuncia con la conexión
$denuncia = new ApiDenuncia($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos JSON del cuerpo de la solicitud
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    $idDenunciado = isset($data['idDenuncia']) ? $data['idDenuncia'] : null;

    // Validar sesion
    if (empty($_SESSION['usuarios'])) {
        echo json_encode(['error' => 'Debes iniciar sesión para poder denunciar.']);
        exit;
    }

    $idDenunciante = $_SESSION['usuarios'][0]['id'];

    // Validar id denunciado
    if ($idDenunciado === null) {
        echo json_encode(['error' => 'Falta id del producto denunciado.']);
        exit;
    }

    // Llama al metodo para agregar la denuncia
    $denuncia->agregarDenuncia($idDenunciado, $idDenunciante);
}
?>
