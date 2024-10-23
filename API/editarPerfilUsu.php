<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Permitir solicitudes de cualquier origen
header('Access-Control-Allow-Methods: GET, POST, PUT'); // Métodos HTTP permitidos
header('Access-Control-Allow-Headers: Content-Type'); // Encabezados permitidos
require("ConexionDB.php");
session_start();
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

    public function editarPerfil($name, $email, $password, $direction, $numero)
    {
        // Hash de la contraseña antes de almacenar(es un tipo de cifrado de contraseña para que esta no sea legible en la base de datos ni en el servidor pero si sirva para verificar que la contraseña luego sea correcta con password_verify($password, $usuario['contrasena_usu'])) o con:
        // $inputPassword = 'miContraseñaSegura123'; // Contraseña ingresada por el usuario
        //if (password_verify($inputPassword, $hashedPassword)) {
        //    echo "¡Contraseña correcta!";
        //} else {
        //    echo "¡Contraseña incorrecta!";
        //}

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Tú sólo recibes la contraseña del usuario que inicia sesión, la encriptas y comparas los dos hashes.
        $habilitacionUsu = "Habilitado";
        // Preparar la consulta
        $stmt = $this->pdo->prepare("UPDATE usuario SET nombre_usu = ?, contrasena_usu = ?, direccion_usu = ?, telefono_usu = ?, mail_usu = ?, habilitacion_usu = ? WHERE id_usu = ?");
        
        $idUsu = $_SESSION['usuarios'][0]['id'];
        // Ejecutar la consulta
        if ($stmt->execute([$name, $hashedPassword, $direction, $numero, $email, $habilitacionUsu, $idUsu])) {

            // Generar un token de sesión
            // Iniciar sesión
            
            session_destroy();
            
            session_start();
            // Guardar los datos en la sesión
            $_SESSION['usuarios'][] = [ 
                'id' => $idUsu,
                'nombre' => $name,
                'correo' => $email,
                'direccion' => $direction,
                'numero' => $numero,
            ];

            echo json_encode(['message' => 'Cuenta editada exitosamente']);
        } else {
            echo json_encode(['error' => 'Error al editar cuenta']);
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

// Manejo de solicitudes GET y PUT
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $usuarios = $usuario->obtenerTodosUsuarios();
    echo json_encode($usuarios);
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

    // Leer los datos JSON
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    $name = $data['cambiarName'];
    $email = $data['cambiarEmail'];
    $password = $data['cambiarPassword'];
    $direction = $data['cambiarDirection'];
    $numero = $data['cambiarNumero'];
        
    $missingFields = [];

    if ($name === null) $missingFields[] = 'name';
    if ($email === null) $missingFields[] = 'email';
    if ($password === null) $missingFields[] = 'password';
    if ($direction === null) $missingFields[] = 'direction';
    if ($numero === null) $missingFields[] = 'numero';

    if (!empty($missingFields)) {
        echo json_encode(['error' => 'Faltan datos del formulario', 'fields' => $missingFields]);
        exit;
    }

    // Llama al método para agregar el usuario sin necesidad de especificar ID
    $usuario->editarPerfil($name, $email, $password, $direction, $numero);
}
