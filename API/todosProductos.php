<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Permitir solicitudes de cualquier origen
header('Access-Control-Allow-Methods: GET, POST, PUT'); // Métodos HTTP permitidos
header('Access-Control-Allow-Headers: Content-Type'); // Encabezados permitidos
require("ConexionDB.php");
class ApiProductos 
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function obtenerTodos()
    {
        // Verifica si se ha proporcionado un ID
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $stmt = $this->pdo->prepare("SELECT p.*, e.nombre_empresa FROM producto p JOIN empresa e ON p.id_empresa = e.id_empresa WHERE p.id_producto = ?");
            $stmt->execute([$id]);
            $producto = $stmt->fetch(PDO::FETCH_ASSOC);
            // Reemplaza el Id_Empresa con el nombre de la empresa
            if ($producto) {
                $producto['id_empresa'] = $producto['nombre_empresa'];
                unset($producto['nombre_empresa']);
            }
            return $producto;
        } else {
            // Obtener todos los productos
            $stmt = $this->pdo->prepare("SELECT p.*, e.nombre_empresa FROM producto p JOIN empresa e ON p.id_empresa = e.id_empresa");
            $stmt->execute();
            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // Reemplaza Id_Empresa con el nombre de la empresa para todos los productos
            foreach ($productos as &$producto) {
                $producto['id_empresa'] = $producto['nombre_empresa'];
                unset($producto['nombre_empresa']);
            }
            return $productos;
        }
    }

}

//Configuracion de la base de datos
$host = 'localhost';
$dbname = 'weshop';
$username = 'root';
$password = '';

$conexionDB = new ConexionDB($host, $dbname, $username, $password);
$pdo = $conexionDB -> getPDO();
// Crear la instancia de la clase Producto con la conexión
$producto = new ApiProductos($pdo);

// Manejo de solicitudes GET, POST, PUT y DELETE 
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $productos = $producto->obtenerTodos();
    echo json_encode($productos);
}

?>