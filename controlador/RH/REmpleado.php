<?php
// session_start();

// if (!isset($_SESSION['usuario'])) {
//     header("Location: ../../index.php");
//     exit();
// }
?>
<?php

include '../../modelo/db.php';
// Incluir PHPMailer
require_once '../../librerias/PHPMailer-master/src/PHPMailer.php';
require_once '../../librerias/PHPMailer-master/src/SMTP.php';
require_once '../../librerias/PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Datos Personales
$nombre = $_POST['nombre'];
$ap = $_POST['apellidoPaterno'];
$am = $_POST['apellidoMaterno'];
$fn = $_POST['fechaNacimiento'];
$sexo = $_POST['sexo'];
$ec = $_POST['estadoCivil'];
$tel = $_POST['telefono'];
$correo = $_POST['correo'];
$dom = $_POST['domicilio'];

// Datos de Contrato
$rfc = $_POST['rfc'];
$depto = $_POST['departamento'];
$puesto = $_POST['puesto'];
$sueldo = $_POST['sueldo'];

$contrasena = $_POST['contrasena'];

// Insertar datos en la tabla empleado
$sqlEmpleado = "INSERT INTO empleado (nombre, apellidoP, apellidoM, feNac, sexo, estadoCivil, telefono, correo, domicilio) 
VALUES ('$nombre', '$ap', '$am', '$fn', '$sexo', '$ec', '$tel', '$correo', '$dom');";

if ($conn->query($sqlEmpleado) === TRUE) {
    //obtener id del empleado
    $idEmp = $conn->insert_id;
    $feIn = date("Y-m-d"); 
    $feTer = NULL; 
    $estatus = "Activo";

    $sqlContrato = "INSERT INTO contrato (rfc, departamento, puesto, sueldo, feIn, feTer, estatus, idEmp) 
    VALUES ('$rfc', '$depto', '$puesto', '$sueldo', '$feIn', NULL, '$estatus', '$idEmp');";

    if ($conn->query($sqlContrato) === TRUE) {
        //obtener id del empleado
        $idCont = $conn->insert_id;
        $sqlPerfil = "UPDATE perfiles SET contrasena='$contrasena' WHERE idCont='$idCont';";

        if ($conn->query($sqlPerfil) === TRUE) {
            $mail = new PHPMailer(true);

            $sqluser = "SELECT usuarios FROM perfiles WHERE idCont='$idCont';";
            $result = mysqli_query($conn, $sqluser);
            $user = mysqli_fetch_assoc($result);
            $usuario = $user['usuarios'];
 
            try {
                // Configuración del servidor SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'luisd.m.c2002@gmail.com';
                $mail->Password = 'dthdirmjqxminblw';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
        
                // Remitente y destinatario
                $mail->setFrom('luisd.m.c2002@gmail.com', 'SAPAC');
                $mail->addAddress($correo);
        
                // Contenido del correo
                $mail->isHTML(true);
                $mail->Subject = 'Registro exitoso';
                $mail->Body = "Bienvenido a SAPAC. Aqui estan tus credenciales para poder entrar a tu cuenta:<br>Usuario: $usuario<br>Contraseña: $contrasena"; //En formato HTML
                $mail->AltBody = "Bienvenido a SAPAC. Aqui estan tus credenciales para poder entrar a tu cuenta:\nUsuario: $usuario\nContraseña: $contrasena"; // En texto plano
        
                // Enviar correo
                $mail->send();
        
                echo "Empleado y perfil registrados correctamente.";
                header("Location:../../vista/RH/homeRH.php");
            } catch (Exception $e) {
                echo "Hubo un error al enviar el correo. Mailer Error: {$mail->ErrorInfo}";
            }

            
        } else {
            echo "Error al registrar perfil: " . $conn->error;
        }

    } else{
        echo "Error al registrar contrato: " . $conn->error;
    }
} else{
    echo "Error al registrar empleado: " . $conn->error;
}

$conn->close();
?>

