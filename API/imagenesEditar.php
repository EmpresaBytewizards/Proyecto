<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require("subirImagenes.php"); 
    
    // Asegurarse de que el ID del producto fue enviado
    if (isset($_POST['editProductId'])) {
        $idProducto = $_POST['editProductId']; // Obtener el ID del producto desde el POST
        
        // Validar si se subió una imagen
        if (isset($_FILES['editProductImage']) && $_FILES['editProductImage']['error'] === UPLOAD_ERR_OK) {
            // Crear una instancia del cargador de imágenes
            $uploader = new ImageUploader();
            $urlImagen = $uploader->uploadImage($_FILES['editProductImage'], $idProducto); // Intentar subir la imagen

            // Verificar si la subida de la imagen fue exitosa
            if (strpos($urlImagen, 'Error:') === 0) {
                // Mensaje de error al subir la imagen
                echo json_encode(['message' => $urlImagen]);
                exit; // Terminar la ejecución
            }

            // Formatear el enlace de la imagen
            $urlImagen = "../api/assets/" . $urlImagen;
            echo json_encode(['message' => 'Imagen subida exitosamente', 'urlImagen' => $urlImagen]);
        } else {
            // En caso de que no se haya subido una imagen, o si hubo un error
            echo json_encode(['message' => 'Error: No se subió la imagen o hubo un problema durante la subida.']);
        }
    } else {
        // Si no se envió el ID del producto
        echo json_encode(['message' => 'Error: No se proporcionó el ID del producto']);
    }
}
?>
