<?php
    $host = 'localhost';
    $dbname = 'basefinal';
    $username = 'root';
    $password = '';
    header('Content-Type: application/json');

    header('Access-Control-Allow-Origin: *'); // Permitir solicitudes de cualquier origen
    header('Access-Control-Allow-Methods: GET, POST'); // Métodos HTTP permitidos
    header('Access-Control-Allow-Headers: Content-Type'); // Encabezados permitidos
    //Conexion a la base de datos
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname",$username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Error al conectar la base de datos: " . $e->getMessage());
    } 


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
        $habilitacionProducto = 'Habilitado';

        // Obtener el último id_producto
        $stmt = $pdo->query("SELECT MAX(id_producto) FROM producto");
        $ultimoIdProducto = $stmt->fetchColumn();
        $nuevoIdProducto = $ultimoIdProducto ? $ultimoIdProducto + 1 : 1;

        // Preparar la consulta SQL
        $stmt = $pdo->prepare("INSERT INTO producto (id_producto, titulo, imagen, precio_base, condicion, stock, nombre_empresa, descripcion, categoria, habilitacion_Producto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // Ejecutar la consulta
        if ($stmt->execute([$nuevoIdProducto, $nombreProducto, $imagenProducto, $precioProducto, $condicionProducto, $stockProducto, $nombreEmpresa, $descripcionProducto, $categoriaProducto, $habilitacionProducto])) {
            echo json_encode(['message' => 'Producto creado exitosamente']);
        } else {
            echo json_encode(['message' => 'Error al crear producto']);
        }
    }

?>