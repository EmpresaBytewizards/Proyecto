<?php
session_start();
require "../correo.php";


function getPayPalAccessToken()
    {
        // Credenciales del cliente PayPal
        $clientId = 'AYEgaarDLE-U7tFC2xgrRXcDnIyEaWPq0TkE1joN78Uv2M_wVU2TTB160ICPgAP2Ie8Y13Ell1tcP-QX';
        $secret = 'EMq_a8-QApduN56dXiBV00DgkEEsg-ZCssrbC5_n_AlihZ9Qy_HvHV5kulAEM0svu9GmWrqnKdPFb0Oq';

        // URL de la API de PayPal para obtener el token
        $url = "https://api.sandbox.paypal.com/v1/oauth2/token";

        // Inicializar cURL
        $ch = curl_init();

        // Configurar opciones de cURL
        curl_setopt($ch, CURLOPT_URL, $url); // Establece la URL para la solicitud
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Para recibir la respuesta como string
        curl_setopt($ch, CURLOPT_POST, true); // Método POST
        curl_setopt($ch, CURLOPT_USERPWD, "$clientId:$secret"); // Autenticación básica
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials"); // Parámetros del POST

        // Ejecutar la solicitud
        $response = curl_exec($ch);

        // Manejo de errores de cURL
        if (curl_errno($ch)) {
            throw new Exception('Error en cURL: ' . curl_error($ch)); // Lanza una excepción si hay un error
        }

        // Decodificar la respuesta JSON
        $result = json_decode($response);

        // Cerrar la conexión cURL
        curl_close($ch);

        // Retornar el token de acceso
        return $result->access_token; // Retorna el token obtenido
    }

    // Función para confirmar el pago en PayPal
function executePayPalPayment($paymentId, $payerId)
{
    // Obtener el token de acceso
    $accessToken = getPayPalAccessToken();

    // URL para ejecutar el pago, utilizando el ID del pago
    $url = "https://api.sandbox.paypal.com/v1/payments/payment/$paymentId/execute";

    // Datos a enviar en la solicitud
    $data = json_encode(["payer_id" => $payerId]); // El ID del pagador

    // Inicializar cURL
    $ch = curl_init();

    // Configurar opciones de cURL
    curl_setopt($ch, CURLOPT_URL, $url); // Establece la URL para la solicitud
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Para recibir la respuesta como string
    curl_setopt($ch, CURLOPT_POST, true); // Método POST
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // Datos a enviar
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json", // Tipo de contenido
        "Authorization: Bearer $accessToken" // Token de acceso para autenticación
    ]);

    // Ejecutar la solicitud
    $response = curl_exec($ch);

    // Manejo de errores de cURL
    if (curl_errno($ch)) {
        throw new Exception('Error en cURL: ' . curl_error($ch)); // Lanza una excepción si hay un error
    }

    // Decodificar la respuesta JSON
    $result = json_decode($response);

    // Cerrar la conexión cURL
    curl_close($ch);

    // Verificar si el pago fue aprobado
    if ($result->state == "approved") {
        return true; // Retorna true si el pago fue confirmado
    } else {
        throw new Exception('Error en la confirmación del pago'); // Lanza excepción si el pago no fue aprobado
    }
}



// Obtener los parámetros después de la redirección de PayPal
$paymentId = $_GET['paymentId']; // ID del pago obtenido de la URL
$payerId = $_GET['PayerID']; // ID del pagador obtenido de la URL
$emailSender = new EmailSender();
$accessToken = getPayPalAccessToken();
$emailSender->setFrom('empresa.bytewizards.3bg@gmail.com', 'ByteWizards');
$emailSender->addRecipient($_SESSION['usuarios'][0]['correo'], $_SESSION['usuarios'][0]['nombre']);
// paymentId=$paymentId&payerId=$payerId
$result = $emailSender->sendEmail('Rastreo de su pedido', 'Este es el enlace para el rastreo de su paquete: http://localhost/bytewizards/interfaz/confirmacionPago.php?paymentId=' . $paymentId . '&token=' . $accessToken . '&PayerID=' . $payerId);
echo $result;
include("../subirDatosCarrito.php");
header('Location: http://localhost/bytewizards/interfaz/confirmacionPago.php?paymentId=' . $paymentId . '&token=' . $accessToken . '&PayerID=' . $payerId);
?>