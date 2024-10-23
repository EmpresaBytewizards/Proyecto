<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Ajusta esto según tu método de instalación

class EmailSender {
    private $mailer;

    // Credenciales por defecto
    private $host = 'sandbox.smtp.mailtrap.io';
    private $username = 'e338fe70269e59';
    private $password = '65e269b20c2b6f';
    private $port = 2525;
    private $secure = 'tls';

    public function __construct() {
        $this->mailer = new PHPMailer(true);
        
        // Configuración SMTP
        $this->mailer->isSMTP();
        $this->mailer->Host = $this->host;
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $this->username;
        $this->mailer->Password = $this->password;
        $this->mailer->SMTPSecure = $this->secure;
        $this->mailer->Port = $this->port;
    }

    public function setFrom($email, $name) {
        $this->mailer->setFrom($email, $name);
    }

    public function addRecipient($email, $name) {
        $this->mailer->addAddress($email, $name);
    }

    public function sendEmail($subject, $body, $isHTML = false) {
        $this->mailer->isHTML($isHTML);
        $this->mailer->Subject = $subject;
        $this->mailer->Body = $body;

        try {
            $this->mailer->send();
            return 'Message has been sent';
        } catch (Exception $e) {
            return 'Message could not be sent. Mailer Error: ' . $this->mailer->ErrorInfo;
        }
    }
}

$emailSender = new EmailSender();


$emailSender->setFrom('empresa.bytewizards.3bg@gmail.com', 'De ByteWizards');
$emailSender->addRecipient($_SESSION['usuarios'][0]['correo'], 'Para '.$_SESSION['usuarios'][0]['nombre']);

// paymentId=$paymentId&payerId=$payerId
$result = $emailSender->sendEmail('Rastreo de su pedido', 'Este es el enlace para el rastreo de su paquete: http://localhost/bytewizards/interfaz/rastreo.php?paymentId='.$paymentId.'&token='.$accessToken.'&payerId='.$payerId);
echo $result;