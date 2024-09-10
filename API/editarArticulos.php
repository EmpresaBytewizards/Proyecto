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
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        // Recolectar los datos del formulario, excepto el ID
        $idProducto = isset($data['editProductId']) ? $data['editProductId'] : null;
        $nombreProducto = isset($data['editNombreProducto']) ? $data['editNombreProducto'] : null;
        $imagenProducto = isset($data['editProductImage']) ? $data['editProductImage'] : null;
        $precioProducto = isset($data['editPrecioProducto']) ? $data['editPrecioProducto'] : null;
        $condicionProducto = isset($data['editCondicionProducto']) ? $data['editCondicionProducto'] : null;
        $stockProducto = isset($data['editStockProducto']) ? $data['editStockProducto'] : null;
        $descripcionProducto = isset($data['editDescripcionProducto']) ? $data['editDescripcionProducto'] : null;
        $categoriaProducto = isset($data['editCategoriaProducto']) ? $data['editCategoriaProducto'] : null;
        $habilitacionProducto = isset($data['habilitacionProducto']) ? $data['habilitacionProducto'] : null;

        // Verificar si faltan campos
        $missingFields = [];
        if ($nombreProducto === null) $missingFields[] = 'editNombreProducto';
        if ($imagenProducto === null) $missingFields[] = 'editProductImage';
        if ($precioProducto === null) $missingFields[] = 'editPrecioProducto';
        if ($condicionProducto === null) $missingFields[] = 'editCondicionProducto';
        if ($stockProducto === null) $missingFields[] = 'editStockProducto';
        if ($descripcionProducto === null) $missingFields[] = 'editDescripcionProducto';
        if ($categoriaProducto === null) $missingFields[] = 'editCategoriaProducto';
        if ($habilitacionProducto === null) $missingFields[] = 'habilitacionProducto';

        if (!empty($missingFields)) {
            echo json_encode(['message' => 'Faltan datos del formulario', 'fields' => $missingFields]);
            exit;
        }

        // Crear o editar producto
        $nombreEmpresa = 'ByteWizzards';  // Valor estático

        if ($idProducto !== null) {
            // Editar producto existente (UPDATE)
            $stmt = $pdo->prepare("UPDATE producto SET titulo = ?, imagen = ?, precio_base = ?, condicion = ?, stock = ?, descripcion = ?, categoria = ?, habilitacion_producto = ? 
                                    WHERE id_producto = ?");
        
            if ($stmt->execute([$nombreProducto, $imagenProducto, $precioProducto, $condicionProducto, $stockProducto, $descripcionProducto, $categoriaProducto, $habilitacionProducto, $idProducto])) {
                echo json_encode(['message' => 'Producto editado exitosamente']);
            } else {
                echo json_encode(['message' => 'Error al editar producto']);
            }
        } else {
            // Editar producto existente (UPDATE)
            $stmt = $pdo->prepare("UPDATE producto SET titulo = ?, imagen = ?, precio_base = ?, condicion = ?, stock = ?, descripcion = ?, categoria = ? 
                                WHERE id_producto = ?");

            if ($stmt->execute([$nombreProducto, $imagenProducto, $precioProducto, $condicionProducto, $stockProducto, $descripcionProducto, $categoriaProducto, $idProducto])) {
                echo json_encode(['message' => 'Producto editado exitosamente']);
            } else {
                echo json_encode(['message' => 'Error al editar producto']);
            }
        }
    }

?>