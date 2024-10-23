<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Permitir solicitudes de cualquier origen
header('Access-Control-Allow-Methods: GET, POST, PUT'); // Métodos HTTP permitidos
header('Access-Control-Allow-Headers: Content-Type'); // Encabezados permitidos

class Database {
    private $pdo;

    public function __construct($host, $dbname, $username, $password) {
        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error de conexión: ' . $e->getMessage()]);
            exit; // Termina el script si hay un error de conexión
        }
    }

    public function getNombreEmpresa() {
        // Preparar la consulta
        $stmt = $this->pdo->prepare("SELECT e.nombre_empresa FROM producto p JOIN empresa e ON p.id_empresa = e.id_empresa;");
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Obtener los resultados
            $nombreEmpresa = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // Enviar el resultado como objeto JSON
            echo json_encode(['nombreEmpresa' => $nombreEmpresa]);
        } else {
            // Manejo de errores en caso de que la consulta falle
            echo json_encode(['error' => 'No se pudo ejecutar la consulta']);
        }
    }
}

// Configuración de la base de datos
$host = 'localhost';
$dbname = 'weshop';
$username = 'root';
$password = '';

// Crear instancia de la clase Database
$db = new Database($host, $dbname, $username, $password);
$db->getNombreEmpresa(); // Llamar al método para obtener nombres de empresa
?>
