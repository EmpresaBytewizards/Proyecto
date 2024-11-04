<?php
require "../API/correo.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WeSHop store -best deals-</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <div class="header__top">
            <div class="logo__container">
                <img src="tienda/Logopagina tr borde.png" alt="Logo de We Shop" id="logo_pagina_rastreo">
            </div>
        </div>
        <div class="blackbar"> ENVÍO Y DEVOLUCIONES GRATIS </div>
    </header>
    <main>
        <!--<section class="concarrusel">-->
        <br>

        <div class="flexCenter">
            <?php
            // Función para obtener el token de acceso de PayPal
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

            try {
                // Intentar ejecutar el pago
                if (executePayPalPayment($paymentId, $payerId)) {
                    echo "<h1 class='exitoPago'>Pago confirmado con éxito</h1>"; // Mensaje de éxito
                    echo "<p><a href='index.php' style='color: #1900ff;'>¿Desea volver a la pagina principal? ¡Presiona aquí!</a></p>";
                }
            } catch (Exception $error) {
                // Manejo de excepciones
                echo "Error: " . $error->getMessage(); // Mensaje de error si algo falla
            }
            ?>
        </div>
        <div class="renderZone">
        </div>
        <br>


    </main>





    <footer>
        <div>
            <div class="">
                <ul>
                    <li>Contacto:</li>
                    <li>Envianos un email: empresa.bytewizards.3bg@gmail.com</li>
                    <li>Teléfono: xxx-xx-xx</li>
                </ul>
            </div>
            <div class="">
                <ul>
                    <li>Cliente:</li>
                    <li>DGETP-UTU</li>
                    <li>Teléfono: 2208 9891</li>
                </ul>
            </div>
            <div class="">
                <ul>
                    <li>Equipo de Desarrollo:</li>
                    <li>ByteWizards Corporation</li>
                </ul>
            </div>
        </div>
    </footer>
</body>
<script src="rastreo.js"></script>
<script src="jquery-3.7.1.min.js"></script>

</html>

