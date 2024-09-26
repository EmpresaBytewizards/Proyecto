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

        $name = isset($data['name']) ? $data['name'] : null;
        $email = isset($data['email']) ? $data['email'] : null;
        $password = isset($data['password']) ? $data['password'] : null;
        $country = isset($data['country']) ? $data['country'] : null;
        $direction = isset($data['direction']) ? $data['direction'] : null;
        $regionLegalDomicilio = isset($data['regionLegalDomicilio']) ? $data['regionLegalDomicilio'] : null;
        
        $missingFields = [];

        if ($name === null) $missingFields[] = 'name';
        if ($email === null) $missingFields[] = 'email';
        if ($password === null) $missingFields[] = 'password';
        if ($country === null) $missingFields[] = 'country';
        if ($direction === null) $missingFields[] = 'direction';
        if ($regionLegalDomicilio === null) $missingFields[] = 'regionLegalDomicilio';

        if (!empty($missingFields)) {
            echo json_encode(['message' => 'Faltan datos del formulario', 'fields' => $missingFields]);
            exit;
        }

        // Verificar si el nombre de usuario ya existe en la base de datos
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE nombre_usu = :name");
        $stmt->execute([':name' => $name]);
        $userExists = $stmt->fetchColumn();
        
        // Obtener el último id_producto
        $stmt = $pdo->query("SELECT MAX(id_producto) FROM producto");
        $ultimoIdUsu = $stmt->fetchColumn();
        $nuevoIdUsu = $ultimoIdUsu ? $ultimoIdUsu + 1 : 1;

        if ($userExists > 0) {
            // Si el nombre de usuario ya existe
            echo json_encode(['message' => 'El nombre de usuario ya está registrado']);
            exit;
        }

        // Preparar la consulta SQL
        $stmt = $pdo->prepare("INSERT INTO producto (nombre_usu, contrasena_usu, mail_usu, pais_usu, direccion_usu, region_legal_domicilio) VALUES (?, ?, ?, ?, ?, ?)");

        // Ejecutar la consulta
        if ($stmt->execute([$name, $password, $email, $country, $direction, $regionLegalDomicilio])) {
            echo json_encode(['message' => 'Producto creado exitosamente']);
        } else {
            echo json_encode(['message' => 'Error al crear producto']);
        }
    }

?>