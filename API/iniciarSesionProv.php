<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Permitir solicitudes de cualquier origen
header('Access-Control-Allow-Methods: GET, POST, PUT'); // Métodos HTTP permitidos
header('Access-Control-Allow-Headers: Content-Type'); // Encabezados permitidos
require("ConexionDB.php");

// Configuración de la base de datos
$host = 'localhost';
$dbname = 'weshop2';
$username = 'root';
$password = ''; // Cambia la contraseña si es necesario

$conexionDB = new ConexionDB($host, $dbname, $username, $password);
$pdo = $conexionDB->getPDO();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['email']) && isset($_GET['password'])) {
        $email = $_GET['email'];
        $password = $_GET['password'];

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
            echo json_encode(['error' => 'Usuario no encontrado'.$email]);
        }
    } else {
        echo json_encode(['error' => 'Faltan datos del formulario']);
    }
}
?>
