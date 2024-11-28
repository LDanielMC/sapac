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

// Incluir PHPMailer
require_once '../../librerias/PHPMailer-master/src/PHPMailer.php';
require_once '../../librerias/PHPMailer-master/src/SMTP.php';
require_once '../../librerias/PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Configuración inicial para evitar problemas
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['emails']) || !is_array($input['emails'])) {
        echo json_encode(['success' => false, 'message' => 'Datos inválidos.']);
        exit;
    }

    $emails = $input['emails'];
    $subject = "Recordatorio: Documento de Entrega Pendiente";

    // Mensaje de texto plano con saltos de línea para formato
    $message = "Estimado/a,\n\nEsperamos que este mensaje le encuentre bien. Queremos recordarle que tiene pendiente la entrega de su documento de Entrega. Es importante cumplir con este requisito dentro del plazo establecido para evitar inconvenientes administrativos.\n\nLe solicitamos amablemente que realice la entrega lo antes posible.\n\nPara cualquier duda o aclaracion, estamos a su disposicion.\n\nAtentamente,\nComisaria SAPAC\n\n\n\n(Se han quitado las tildes para una mejor visualizacion)";


    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'luisd.m.c2002@gmail.com';
        $mail->Password = 'REDACTED_APP_PASSWORD';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Configuración del correo
        $mail->setFrom('luisd.m.c2002@gmail.com', 'Comisaria SAPAC');
        $mail->isHTML(false);  // Correo en texto plano
        $mail->Subject = $subject;
        $mail->Body = $message;

        // Agregar todos los correos al objeto PHPMailer
        foreach ($emails as $email) {
            $mail->addAddress($email);
        }

        // Enviar los correos
        if ($mail->send()) {
            // Respuesta exitosa
            echo json_encode(['success' => true, 'message' => "Se enviaron " . count($emails) . " correos."]);
        } else {
            echo json_encode(['success' => false, 'message' => "No se pudieron enviar los correos."]);
        }

        // Limpiar las direcciones después de enviar todos los correos
        $mail->clearAddresses();

        exit; 
    } catch (Exception $e) {
        // Captura de errores
        echo json_encode(['success' => false, 'message' => "Error al enviar los correos: {$mail->ErrorInfo}"]);
        exit; 
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
    exit; 
}

