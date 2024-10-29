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
        $stmt = $this->pdo->prepare("SELECT * FROM empresa");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function editarPerfil($email, $password, $direction, $numero, $nombreEmpresa)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM empresa WHERE mail_empresa = ?");
        $stmt->execute([$email]);
        $emailExists = $stmt->fetchColumn() > 0;

        // Verificar si el nombre de empresa ya existe
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM empresa WHERE nombre_empresa = ?");
        $stmt->execute([$nombreEmpresa]);
        $nameExists = $stmt->fetchColumn() > 0;
        
        if (($emailExists && $email != $_SESSION['empresas'][0]['correo']) || ($nameExists && $nombreEmpresa != $_SESSION['empresas'][0]['nombre'])) {
            $conflictingFields = [];
            if ($emailExists) $conflictingFields[] = 'email';
            if ($nameExists) $conflictingFields[] = 'nombre_empresa';

            echo json_encode(['error' => 'Dato ya ocupado', 'fields' => $conflictingFields]);
            exit;
        }
        // Hash de la contraseña antes de almacenar(es un tipo de cifrado de contraseña para que esta no sea legible en la base de datos ni en el servidor pero si sirva para verificar que la contraseña luego sea correcta con password_verify($password, $usuario['contrasena_usu'])) o con:
        // $inputPassword = 'miContraseñaSegura123'; // Contraseña ingresada por el usuario
        //if (password_verify($inputPassword, $hashedPassword)) {
        //    echo "¡Contraseña correcta!";
        //} else {
        //    echo "¡Contraseña incorrecta!";
        //}

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Tú sólo recibes la contraseña del usuario que inicia sesión, la encriptas y comparas los dos hashes.
        $habilitacionProv = "Habilitado";
        // Preparar la consulta
        $stmt = $this->pdo->prepare("UPDATE empresa SET nombre_empresa = ?, contrasena_empresa = ?, ubicacion_fisica = ?, telefono_empresa = ?, mail_empresa = ?, habilitacion_empresa = ? WHERE id_empresa = ?");
        
        $idUsu = $_SESSION['empresas'][0]['id'];
        // Ejecutar la consulta
        if ($stmt->execute([$nombreEmpresa, $hashedPassword, $direction, $numero, $email, $habilitacionProv, $idUsu])) {

            // Generar un token de sesión
            // Iniciar sesión
            
            session_destroy();
            
            session_start();
            // Guardar los datos en la sesión
            $_SESSION['empresas'][] = [ 
                'id' => $idUsu,
                'nombre' => $nombreEmpresa,
                'correo' => $email,
                'direccion' => $direction,
                'numero' => $numero,
                'habilitacion' => $habilitacionProv
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


    $email = $data['cambiarEmail'];
    $password = $data['cambiarPassword'];
    $direction = $data['cambiarDirection'];
    $numero = $data['cambiarNumero'];
    $nombreEmpresa = $data['cambiarNombre'];

    $missingFields = [];

    if ($email === null) $missingFields[] = 'email';
    if ($password === null) $missingFields[] = 'password';
    if ($direction === null) $missingFields[] = 'direction';
    if ($numero === null) $missingFields[] = 'numero';
    if ($nombreEmpresa === null) $missingFields[] = 'nombre_empresa';

    if (!empty($missingFields)) {
        echo json_encode(['error' => 'Faltan datos del formulario', 'fields' => $missingFields]);
        exit;
    }

    // Llama al método para agregar el usuario sin necesidad de especificar ID
    $usuario->editarPerfil($email, $password, $direction, $numero, $nombreEmpresa);
}
