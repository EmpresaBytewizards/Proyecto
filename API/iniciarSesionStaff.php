<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Permitir solicitudes de cualquier origen
header('Access-Control-Allow-Methods: POST'); // Métodos HTTP permitidos
header('Access-Control-Allow-Headers: Content-Type'); // Encabezados permitidos
require("ConexionDB.php");
require "correo.php";

// Configuración de la base de datos
$host = 'localhost';
$dbname = 'backoffice';
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
        $stmt = $pdo->prepare("SELECT * FROM staff WHERE mail_staff = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            // Verificar la contraseña 
            if (password_verify($password, $usuario['contrasena_staff'])) {
                session_start();
                session_destroy();
                session_start();
                $_SESSION['staffs'][] = [ 
                    'id' => $usuario['id_staff'],
                    'nombre' => $usuario['nombre_staff'],
                    'correo' => $usuario['mail_staff'],
                    'direccion' => $usuario['ubicacion_staff'],
                    'numero' => $usuario['telefono_staff'],
                    'tipo' => $usuario['tipo_staff']
                ];
                $emailSender = new EmailSender();
                $emailSender->setFrom('empresa.bytewizards.3bg@gmail.com', 'ByteWizards');
                $emailSender->addRecipient($_SESSION['staffs'][0]['correo'], $_SESSION['staffs'][0]['nombre']);
                $result = $emailSender->sendEmail('Inicio de sesion', 'Bienvenido de nuevo a weshop. Si usted no ha sido quien inicio sesion, contactese con nosotros de inmediato a este correo: empresa.bytewizards.3bg@gmail.com.' );
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
