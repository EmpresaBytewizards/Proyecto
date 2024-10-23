<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Permitir solicitudes de cualquier origen
header('Access-Control-Allow-Methods: POST'); // Métodos HTTP permitidos
header('Access-Control-Allow-Headers: Content-Type'); // Encabezados permitidos
require("ConexionDB.php");

// Configuración de la base de datos
$host = 'localhost';
$dbname = 'weshop';
$username = 'root';
$password = ''; // Cambia la contraseña si es necesario

$conexionDB = new ConexionDB($host, $dbname, $username, $password);
$pdo = $conexionDB->getPDO();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decodificar el contenido JSON enviado en la solicitud
    $inputData = json_decode(file_get_contents('php://input'), true);
    
    if (isset($inputData['email']) && isset($inputData['password'])) {
        $email = $inputData['email'];
        $password = $inputData['password'];

        // Verificar si faltan campos
        $missingFields = [];
        if (empty($email)) $missingFields[] = 'email';
        if (empty($password)) $missingFields[] = 'password';

        if (!empty($missingFields)) {
            echo json_encode(['error' => 'Faltan datos del formulario', 'fields' => $missingFields]);
            exit;
        }

        // Consultar usuario en la base de datos
        $stmt = $pdo->prepare("SELECT * FROM empresa WHERE mail_empresa = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            // Verificar la contraseña 
            if (password_verify($password, $usuario['contrasena_empresa'])) {
                session_start();
                session_destroy();
                session_start();
                $_SESSION['empresas'][] = [ 
                    'id' => $usuario['id_empresa'],
                    'nombre' => $usuario['nombre_empresa'],
                    'correo' => $usuario['mail_empresa'],
                    'direccion' => $usuario['ubicacion_fisica'],
                    'numero' => $usuario['telefono_empresa'],
                    'habilitacion' => $usuario['habilitacion_empresa']
                ];
                echo json_encode(['message' => 'Inicio de sesión exitoso']);
            } else {
                echo json_encode(['error' => 'Contraseña incorrecta']);
            }
        } else {
            echo json_encode(['error' => 'Usuario no encontrado']);
        }
    } else {
        echo json_encode(['error' => 'Faltan datos del formulario']);
    }
}
?>
