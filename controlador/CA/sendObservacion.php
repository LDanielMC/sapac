<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
    exit();
}
// Verificar si es el comisario
if ($_SESSION['puesto'] !== 'Comisario') {
    header("Location: ../../index.php");
    exit();
}
?>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../../librerias/PHPMailer-master/src/PHPMailer.php';
require_once '../../librerias/PHPMailer-master/src/SMTP.php';
require_once '../../librerias/PHPMailer-master/src/Exception.php';

function enviarCorreo($correo, $asunto, $mensaje) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'luisd.m.c2002@gmail.com';
        $mail->Password = 'REDACTED_APP_PASSWORD';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('luisd.m.c2002@gmail.com', 'Comisaria SAPAC');
        $mail->addAddress($correo);

        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body = $mensaje;

        $mail->send();
    } catch (Exception $e) {
        error_log("Error al enviar correo: {$mail->ErrorInfo}");
    }
}
?>
