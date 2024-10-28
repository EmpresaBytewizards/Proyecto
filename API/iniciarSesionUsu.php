<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Permitir solicitudes de cualquier origen
header('Access-Control-Allow-Methods: POST'); // Solo POST permitido
header('Access-Control-Allow-Headers: Content-Type'); // Encabezados permitidos

require("ConexionDB.php");
require "correo.php";

// Configuración de la base de datos
$host = 'localhost';
$dbname = 'weshop';
$username = 'root';
$password = ''; // Cambia la contraseña si es necesario

$conexionDB = new ConexionDB($host, $dbname, $username, $password);
$pdo = $conexionDB->getPDO();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Leer el contenido JSON enviado en el cuerpo de la solicitud
    $input = file_get_contents('php://input');
    $data = json_decode($input, true); // Decodificar los datos JSON a un array asociativo

    if (isset($data['email']) && isset($data['password'])) {
        $email = $data['email'];
        $password = $data['password'];

        // Verificar si faltan campos
        $missingFields = [];
        if (empty($email)) $missingFields[] = 'email';
        if (empty($password)) $missingFields[] = 'password';

        if (!empty($missingFields)) {
            echo json_encode(['error' => 'Faltan datos del formulario', 'fields' => $missingFields]);
            exit;
        }

        // Consultar usuario en la base de datos
        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE mail_usu = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            // Verificar la contraseña 
            if (password_verify($password, $usuario['contrasena_usu'])) {
                session_start();
                session_destroy();
                session_start();
                $_SESSION['usuarios'][] = [ 
                    'id' => $usuario['id_usu'],
                    'nombre' => $usuario['nombre_usu'],
                    'correo' => $usuario['mail_usu'],
                    'direccion' => $usuario['direccion_usu'],
                    'numero' => $usuario['telefono_usu'],
                    'habilitacion' => $usuario['habilitacion_usu']
                ];
                $emailSender = new EmailSender();
                $emailSender->setFrom('empresa.bytewizards.3bg@gmail.com', 'ByteWizards');
                $emailSender->addRecipient($_SESSION['usuarios'][0]['correo'], $_SESSION['usuarios'][0]['nombre']);
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
