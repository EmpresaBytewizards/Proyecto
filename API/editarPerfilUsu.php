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
        // Hash de la contraseña antes de almacenar
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Solo recibir la contraseña del usuario que inicia sesión

        // Obtener el ID del usuario actual
        $idUsu = $_SESSION['usuarios'][0]['id'];

        // Verificar si el correo ya está en uso, pero ignorar el actual
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM usuario WHERE mail_usu = ? AND id_usu != ?");
        $stmt->execute([$email, $idUsu]);
        $emailExists = $stmt->fetchColumn() > 0;

        // Si el correo ya existe, devolver un error
        if ($emailExists) {
            echo json_encode(['error' => 'Dato ya ocupado: ', 'fields' => ['email']]);
            exit; // Salir del método para evitar la creación de cuenta
        }

        // Verificar si el nombre ya está en uso, pero ignorar el actual
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM usuario WHERE nombre_usu = ? AND id_usu != ?");
        $stmt->execute([$name, $idUsu]);
        $nameExists = $stmt->fetchColumn() > 0;

        // Si el nombre ya existe y no es el mismo que el actual
        if ($nameExists) {
            echo json_encode(['error' => 'Dato ya ocupado: ', 'fields' => ['nombre']]);
            exit;  
        }

        $habilitacionUsu = "Habilitado";

        // Preparar la consulta
        $stmt = $this->pdo->prepare("UPDATE usuario SET nombre_usu = ?, contrasena_usu = ?, direccion_usu = ?, telefono_usu = ?, mail_usu = ?, habilitacion_usu = ? WHERE id_usu = ?");
        
        // Ejecutar la consulta
        if ($stmt->execute([$name, $hashedPassword, $direction, $numero, $email, $habilitacionUsu, $idUsu])) {
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
