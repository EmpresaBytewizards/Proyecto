<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Permitir solicitudes de cualquier origen
header('Access-Control-Allow-Methods: GET, POST, PUT'); // Métodos HTTP permitidos
header('Access-Control-Allow-Headers: Content-Type'); // Encabezados permitidos
require("ConexionDB.php");
require("subirImagenes.php"); 
session_start();

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

    public function agregar($nuevoIdProducto, $nombreProducto, $urlImagen, $precioProducto, $condicionProducto, $stockProducto, $nombreEmpresa, $descripcionProducto, $categoriaProducto, $habilitacion_producto)
    {
        $stmt = $this->pdo->prepare("INSERT INTO producto (id_producto, titulo, imagen, precio_base, condicion, stock, nombre_empresa, descripcion, categoria, habilitacion_producto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // Ejecutar la consulta
        if ($stmt->execute([$nuevoIdProducto, $nombreProducto, $urlImagen, $precioProducto, $condicionProducto, $stockProducto, $nombreEmpresa, $descripcionProducto, $categoriaProducto, $habilitacion_producto])) {
            echo json_encode(['message' => 'Producto creado exitosamente']);
        } else {
            echo json_encode(['message' => 'Error al crear producto']);
        }
    }

    public function editar($nombreProducto, $precioProducto, $condicionProducto, $stockProducto, $descripcionProducto, $categoriaProducto, $habilitacion_producto, $idProducto)
    {
    // Editar producto existente (UPDATE)
    $stmt = $this->pdo->prepare("UPDATE producto SET titulo = ?, precio_base = ?, condicion = ?, stock = ?, descripcion = ?, categoria = ?, habilitacion_producto = ? WHERE id_producto = ?");

    // Ejecutar la consulta y devolver el resultado
    return $stmt->execute([$nombreProducto, $precioProducto, $condicionProducto, $stockProducto, $descripcionProducto, $categoriaProducto, $habilitacion_producto, $idProducto]);
    }

}


//Configuracion de la base de datos
$host = 'localhost';
$dbname = 'weshop2';
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
    // $input = file_get_contents('php://input');
    // $data = json_decode($input, true);

    // $nombreProducto = isset($data['nombreProducto']) ? $data['nombreProducto'] : null;
    // $precioProducto = isset($data['precioProducto']) ? $data['precioProducto'] : null;
    // $condicionProducto = isset($data['condicionProducto']) ? $data['condicionProducto'] : null;
    // $stockProducto = isset($data['stockProducto']) ? $data['stockProducto'] : null;
    // $descripcionProducto = isset($data['descripcionProducto']) ? $data['descripcionProducto'] : null;
    // $categoriaProducto = isset($data['categoriaProducto']) ? $data['categoriaProducto'] : null;

    $nombreProducto = $_POST['nombreProducto'];
    $precioProducto = $_POST['precioProducto'];
    $condicionProducto = $_POST['condicionProducto'];
    $stockProducto = $_POST['stockProducto'];
    $descripcionProducto = $_POST['descripcionProducto'];
    $categoriaProducto = $_POST['categoriaProducto'];
    $missingFields = [];

    if ($nombreProducto === null) $missingFields[] = 'nombreProducto';
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
    $nombreEmpresa = $_SESSION['empresas'][0]['nombre'];
    $habilitacion_producto = 'Habilitado';

    // Obtener el último id_producto
    $stmt = $pdo->query("SELECT MAX(id_producto) FROM producto");
    $ultimoIdProducto = $stmt->fetchColumn();
    $nuevoIdProducto = $ultimoIdProducto ? $ultimoIdProducto + 1 : 1;
    $idImagen = $nuevoIdProducto;
    
    // Validar si se subió una imagen
    if (isset($_FILES['addProductImage']) && $_FILES['addProductImage']['error'] === UPLOAD_ERR_OK) {
        // Crear una instancia del cargador de imágenes
        $uploader = new ImageUploader();
        $urlImagen = $uploader->uploadImage($_FILES['addProductImage'], $idImagen); // Intentar subir la imagen

        // Verificar si la subida de la imagen fue exitosa
        if (strpos($urlImagen, 'Error:') === 0) {
            // Mensaje de error al subir la imagen
            echo json_encode(['message' => $urlImagen]);
            exit; // Terminar la ejecución
        }
    } else {
        // Mensaje de error si no se subió la imagen o hubo un problema
        echo json_encode(['message' => 'Error: No se subió la imagen o hubo un problema durante la subida.']);
        exit; // Terminar la ejecución
    }
    $urlImagen = "../api/assets/" . $urlImagen;
    // Este método ya maneja el JSON
    $producto->agregar($nuevoIdProducto, $nombreProducto, $urlImagen, $precioProducto, $condicionProducto, $stockProducto, $nombreEmpresa, $descripcionProducto, $categoriaProducto, $habilitacion_producto);
}


if ($_SERVER['REQUEST_METHOD'] === 'PUT') {


    // Leer los datos JSON
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);


    // Ahora puedes acceder a los datos del formulario
    $idProducto = $data['editProductId']; 
    $nombreProducto = $data['editNombreProducto'];
    $precioProducto = $data['editPrecioProducto'];
    $condicionProducto = $data['editCondicionProducto'];
    $stockProducto = $data['editStockProducto'];
    $descripcionProducto = $data['editDescripcionProducto'];
    $categoriaProducto = $data['editCategoriaProducto'];
    $habilitacion_producto = $data['habilitacionProducto'];


    // Ahora puedes usar estas variables como lo harías normalmente


    $missingFields = [];

    // Verificar si faltan campos
    if (empty($nombreProducto)) $missingFields[] = 'editNombreProducto';
    if (empty($precioProducto)) $missingFields[] = 'editPrecioProducto';
    if (empty($condicionProducto)) $missingFields[] = 'editCondicionProducto';
    // if (empty($stockProducto)) $missingFields[] = 'editStockProducto';
    if (empty($descripcionProducto)) $missingFields[] = 'editDescripcionProducto';
    if (empty($categoriaProducto)) $missingFields[] = 'editCategoriaProducto';
    if (empty($habilitacion_producto)) $missingFields[] = 'habilitacionProducto';

    if ($stockProducto == null){
        $stockProducto = 0;
    }
    
    if (!empty($missingFields)) {
        echo json_encode(['message' => 'Faltan datos del formulario', 'fields' => $missingFields]);
        exit;
    }

    $nombreEmpresa = $_SESSION['empresas'][0]['nombre'];

    
    // Ejecutar la función de editar
    $result = $producto->editar($nombreProducto, $precioProducto, $condicionProducto, $stockProducto, $descripcionProducto, $categoriaProducto, $habilitacion_producto, $idProducto);

    // Verificar si la edición fue exitosa
    if ($result) {
        echo json_encode(['message' => 'Producto editado exitosamente']);
    } else {
        echo json_encode(['message' => 'Error al editar el producto']);
    }
}
