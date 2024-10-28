<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Permitir solicitudes de cualquier origen
header('Access-Control-Allow-Methods: GET, POST, PUT'); // Métodos HTTP permitidos
header('Access-Control-Allow-Headers: Content-Type'); // Encabezados permitidos
require("ConexionDB.php");
require "correo.php";

class ApiUsuarios
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function obtenerTodosUsuarios()
    {
        // Obtener todos los usuarios
        $stmt = $this->pdo->prepare("SELECT * FROM usuario");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function agregar($name, $email, $password, $direction, $numero)
    {
        // Hash de la contraseña antes de almacenar(es un tipo de cifrado de contraseña para que esta no sea legible en la base de datos ni en el servidor pero si sirva para verificar que la contraseña luego sea correcta con password_verify($password, $usuario['contrasena_usu'])) o con:
        // $inputPassword = 'miContraseñaSegura123'; // Contraseña ingresada por el usuario
        //if (password_verify($inputPassword, $hashedPassword)) {
        //    echo "¡Contraseña correcta!";
        //} else {
        //    echo "¡Contraseña incorrecta!";
        //}

        $stmt = $this->pdo->query("SELECT MAX(id_usu) FROM usuario");
        $ultimoIdUsuario = $stmt->fetchColumn();
        $nuevoIdUsuario = $ultimoIdUsuario ? $ultimoIdUsuario + 1 : 1;

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Tú sólo recibes la contraseña del usuario que inicia sesión, la encriptas y comparas los dos hashes.
        $habilitacionUsu = "Habilitado";
        // Preparar la consulta
        $stmt = $this->pdo->prepare("INSERT INTO usuario (id_usu, nombre_usu, mail_usu, contrasena_usu, direccion_usu, telefono_usu, habilitacion_usu) VALUES (?, ?, ?, ?, ?, ?, ?)");

        // Ejecutar la consulta
        if ($stmt->execute([$nuevoIdUsuario, $name, $email, $hashedPassword, $direction, $numero, $habilitacionUsu])) {
            // Obtener el ID del nuevo usuario
            $usuarioId = $this->pdo->lastInsertId();

            // Generar un token de sesión
            // Iniciar sesión
            session_start();
            session_destroy();
            session_start();
            // Guardar los datos en la sesión
            $_SESSION['usuarios'][] = [ 
                'id' => $nuevoIdUsuario,
                'nombre' => $name,
                'correo' => $email,
                'direccion' => $direction,
                'numero' => $numero,
                'habilitacion' => $habilitacionUsu
            ];
            $emailSender = new EmailSender();
            $emailSender->setFrom('empresa.bytewizards.3bg@gmail.com', 'ByteWizards');
            $emailSender->addRecipient($_SESSION['usuarios'][0]['correo'], $_SESSION['usuarios'][0]['nombre']);
            $result = $emailSender->sendEmail('Registro de cuenta', 'Bienvenido a weshop. Si usted no ha sido quien creo la cuenta, contactese con nosotros de inmediato a este correo: empresa.bytewizards.3bg@gmail.com.' );
            echo json_encode(['message' => 'Cuenta creada exitosamente']);
        } else {
            echo json_encode(['message' => 'Error al crear cuenta']);
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

// Crear la instancia de la clase Usuario con la conexión
$usuario = new ApiUsuarios($pdo);

// Manejo de solicitudes GET y POST
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $usuarios = $usuario->obtenerTodosUsuarios();
    echo json_encode($usuarios);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos JSON del cuerpo de la solicitud
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    $name = isset($data['name']) ? $data['name'] : null;
    $email = isset($data['email']) ? $data['email'] : null;
    $password = isset($data['password']) ? $data['password'] : null;
    $direction = isset($data['direction']) ? $data['direction'] : null;
    $numero = isset($data['numero']) ? $data['numero'] : null;
        
    $missingFields = [];

    if ($name === null) $missingFields[] = 'name';
    if ($email === null) $missingFields[] = 'email';
    if ($password === null) $missingFields[] = 'password';
    if ($direction === null) $missingFields[] = 'direction';
    if ($numero === null) $missingFields[] = 'numero';

    if (!empty($missingFields)) {
        echo json_encode(['message' => 'Faltan datos del formulario', 'fields' => $missingFields]);
        exit;
    }

    // Llama al método para agregar el usuario sin necesidad de especificar ID
    $usuario->agregar($name, $email, $password, $direction, $numero);
}
