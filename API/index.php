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
            $stmt = $this->pdo->prepare("SELECT * FROM producto WHERE id_producto = ?");
            $stmt->execute([$id]);
            $producto = $stmt->fetch(PDO::FETCH_ASSOC);
            return $producto;

        } else {
            // Obtener todos los productos
            $stmt = $this->pdo->prepare("SELECT * FROM producto");
            $stmt->execute();
            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $productos;
        }
    }

    public function agregar($nuevoIdProducto, $nombreProducto, $imagenProducto, $precioProducto, $condicionProducto, $stockProducto, $nombreEmpresa, $descripcionProducto, $categoriaProducto, $habilitacion_producto)
    {
        $stmt = $this->pdo->prepare("INSERT INTO producto (id_producto, titulo, imagen, precio_base, condicion, stock, nombre_empresa, descripcion, categoria, habilitacion_producto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // Ejecutar la consulta
        if ($stmt->execute([$nuevoIdProducto, $nombreProducto, $imagenProducto, $precioProducto, $condicionProducto, $stockProducto, $nombreEmpresa, $descripcionProducto, $categoriaProducto, $habilitacion_producto])) {
            echo json_encode(['message' => 'Producto creado exitosamente']);
        } else {
            echo json_encode(['message' => 'Error al crear producto']);
        }
    }

    public function editar($nombreProducto, $imagenProducto, $precioProducto, $condicionProducto, $stockProducto, $descripcionProducto, $categoriaProducto, $habilitacion_producto, $idProducto)
    {
    // Editar producto existente (UPDATE)
    $stmt = $this->pdo->prepare("UPDATE producto SET titulo = ?, imagen = ?, precio_base = ?, condicion = ?, stock = ?, descripcion = ?, categoria = ?, habilitacion_producto = ? WHERE id_producto = ?");

    // Ejecutar la consulta y devolver el resultado
    return $stmt->execute([$nombreProducto, $imagenProducto, $precioProducto, $condicionProducto, $stockProducto, $descripcionProducto, $categoriaProducto, $habilitacion_producto, $idProducto]);
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

/*if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    

    // Obtener los datos JSON del cuerpo de la solicitud
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    $nombreProducto = isset($data['nombreProducto']) ? $data['nombreProducto'] : null;
    $imagenProducto = isset($data['addProductImage']) ? $data['addProductImage'] : null;
    $precioProducto = isset($data['precioProducto']) ? $data['precioProducto'] : null;
    $condicionProducto = isset($data['condicionProducto']) ? $data['condicionProducto'] : null;
    $stockProducto = isset($data['stockProducto']) ? $data['stockProducto'] : null;
    $descripcionProducto = isset($data['descripcionProducto']) ? $data['descripcionProducto'] : null;
    $categoriaProducto = isset($data['categoriaProducto']) ? $data['categoriaProducto'] : null;
    $missingFields = [];

    if ($nombreProducto === null) $missingFields[] = 'nombreProducto';
    if ($imagenProducto === null) $missingFields[] = 'addProductImage';
    if ($precioProducto === null) $missingFields[] = 'precioProducto';
    if ($condicionProducto === null) $missingFields[] = 'condicionProducto';
    if ($stockProducto === null) $missingFields[] = 'stockProducto';
    if ($descripcionProducto === null) $missingFields[] = 'descripcionProducto';
    if ($categoriaProducto === null) $missingFields[] = 'categoriaProducto';

    if (!empty($missingFields)) {
        echo json_encode(['message' => 'Faltan datos del formulario', 'fields' => $missingFields]);
        exit;
    }

    // Si todos los datos están presentes, continúa con la lógica para insertar en la base de datos
    $nombreEmpresa = 'ByteWizzards';
    $habilitacion_producto = 'Habilitado';

    // Obtener el último id_producto
    $stmt = $pdo->query("SELECT MAX(id_producto) FROM producto");
    $ultimoIdProducto = $stmt->fetchColumn();
    $nuevoIdProducto = $ultimoIdProducto ? $ultimoIdProducto + 1 : 1;

    $productos = $producto->agregar($nuevoIdProducto, $nombreProducto, $imagenProducto, $precioProducto, $condicionProducto, $stockProducto, $nombreEmpresa, $descripcionProducto, $categoriaProducto, $habilitacion_producto);
    echo json_encode($productos);
}
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Obtener los datos JSON del cuerpo de la solicitud
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    $nombreProducto = isset($data['nombreProducto']) ? $data['nombreProducto'] : null;
    $imagenProducto = isset($data['addProductImage']) ? $data['addProductImage'] : null;
    $precioProducto = isset($data['precioProducto']) ? $data['precioProducto'] : null;
    $condicionProducto = isset($data['condicionProducto']) ? $data['condicionProducto'] : null;
    $stockProducto = isset($data['stockProducto']) ? $data['stockProducto'] : null;
    $descripcionProducto = isset($data['descripcionProducto']) ? $data['descripcionProducto'] : null;
    $categoriaProducto = isset($data['categoriaProducto']) ? $data['categoriaProducto'] : null;
    $missingFields = [];

    if ($nombreProducto === null) $missingFields[] = 'nombreProducto';
    if ($imagenProducto === null) $missingFields[] = 'addProductImage';
    if ($precioProducto === null) $missingFields[] = 'precioProducto';
    if ($condicionProducto === null) $missingFields[] = 'condicionProducto';
    if ($stockProducto === null) $missingFields[] = 'stockProducto';
    if ($descripcionProducto === null) $missingFields[] = 'descripcionProducto';
    if ($categoriaProducto === null) $missingFields[] = 'categoriaProducto';

    if (!empty($missingFields)) {
        echo json_encode(['message' => 'Faltan datos del formulario', 'fields' => $missingFields]);
        exit;
    }

    // Si todos los datos están presentes, continúa con la lógica para insertar en la base de datos
    $nombreEmpresa = 'ByteWizzards';
    $habilitacion_producto = 'Habilitado';

    // Obtener el último id_producto
    $stmt = $pdo->query("SELECT MAX(id_producto) FROM producto");
    $ultimoIdProducto = $stmt->fetchColumn();
    $nuevoIdProducto = $ultimoIdProducto ? $ultimoIdProducto + 1 : 1;
    $idImagen = $nuevoIdProducto;

    // Este método ya maneja el JSON
    $producto->agregar($nuevoIdProducto, $nombreProducto, $imagenProducto, $precioProducto, $condicionProducto, $stockProducto, $nombreEmpresa, $descripcionProducto, $categoriaProducto, $habilitacion_producto);
}


if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Verificar si el JSON está bien formado
    if ($data === null) {
        echo json_encode(['message' => 'Datos JSON mal formados']);
        exit;
    }

    // Recolectar los datos del formulario
    $idProducto = isset($data['editProductId']) ? $data['editProductId'] : null;
    $nombreProducto = isset($data['editNombreProducto']) ? $data['editNombreProducto'] : null;
    $imagenProducto = isset($data['editProductImage']) ? $data['editProductImage'] : null;
    $precioProducto = isset($data['editPrecioProducto']) ? $data['editPrecioProducto'] : null;
    $condicionProducto = isset($data['editCondicionProducto']) ? $data['editCondicionProducto'] : null;
    $stockProducto = isset($data['editStockProducto']) ? $data['editStockProducto'] : null;
    $descripcionProducto = isset($data['editDescripcionProducto']) ? $data['editDescripcionProducto'] : null;
    $categoriaProducto = isset($data['editCategoriaProducto']) ? $data['editCategoriaProducto'] : null;
    $habilitacion_producto = isset($data['habilitacionProducto']) ? $data['habilitacionProducto'] : null;

    // Verificar si faltan campos
    $missingFields = [];
    if ($nombreProducto === null) $missingFields[] = 'editNombreProducto';
    if ($imagenProducto === null) $missingFields[] = 'editProductImage';
    if ($precioProducto === null) $missingFields[] = 'editPrecioProducto';
    if ($condicionProducto === null) $missingFields[] = 'editCondicionProducto';
    if ($stockProducto === null) $missingFields[] = 'editStockProducto';
    if ($descripcionProducto === null) $missingFields[] = 'editDescripcionProducto';
    if ($categoriaProducto === null) $missingFields[] = 'editCategoriaProducto';
    if ($habilitacion_producto === null) $missingFields[] = 'habilitacionProducto';

    if (!empty($missingFields)) {
        echo json_encode(['message' => 'Faltan datos del formulario', 'fields' => $missingFields]);
        exit;
    }

    // Crear o editar producto
    $nombreEmpresa = 'ByteWizzards';  // Valor estático

    // Ejecutar la función de editar
    $result = $producto->editar($nombreProducto, $imagenProducto, $precioProducto, $condicionProducto, $stockProducto, $descripcionProducto, $categoriaProducto, $habilitacion_producto, $idProducto);

    // Verificar si la edición fue exitosa
    if ($result) {
        echo json_encode(['message' => 'Producto editado exitosamente']);
    } else {
        echo json_encode(['message' => 'Error al editar el producto']);
    }
}
