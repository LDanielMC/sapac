<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
    exit();
}

// Configura la zona horaria
date_default_timezone_set('America/Mexico_City');
require '../../modelo/db.php';
$idEmp = $_SESSION['idEmp'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uploadDirectory = "../../uploads/";

    // Función para manejar la subida de archivos
    function uploadFile($fileKey, $table, $field, $dateField, $idEmp, $conn) {
        global $uploadDirectory;
        echo "Entrando a la función uploadFile para: $fileKey <br>";

        if (!isset($_FILES[$fileKey])) {
            echo "El archivo $fileKey no se recibió correctamente en \$_FILES.<br>";
            return;
        }

        if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES[$fileKey]['tmp_name'];
            $originalFileName = $_FILES[$fileKey]['name'];
            
            // Obtener fecha y hora actuales en formato "Ymd_His"
            $dateTime = (new DateTime())->format("Y-m-d_H-i-s-u");
            
            // Crear el nuevo nombre del archivo: fecha-hora + nombre original
            $newFileName = $dateTime . "_" . $originalFileName;
            $filePath = $uploadDirectory . $newFileName;

            if (move_uploaded_file($fileTmpPath, $filePath)) {
                // Construir consulta con el campo de fecha correcto
                $sql = "UPDATE $table SET $field = '$filePath', estado = 'Pendiente', $dateField = CURRENT_DATE where idEmp = $idEmp
                        AND ($field IS NULL OR $field = '');";
                
                if (mysqli_query($conn, $sql)) {
                    $rowsAffected = mysqli_affected_rows($conn);
                    if ($rowsAffected > 0) {
                    if($table == 'dpinicial' || $table == 'dpmayo' || $table == 'dpconclusion'){
                        header("Location:../../vista/SP/sucessDP.php");
                    } elseif($table == 'entrega'){
                        header("Location:../../vista/SP/sucessEN.php");
                    } elseif($table == 'recepcion'){
                        header("Location:../../vista/SP/sucessRE.php");
                    }
                } else {
                    header("Location:../../vista/SP/yaexiste.php");
                    }
                } else {
                    header("Location:../../vista/SP/error.php");
                }
            } else {
                header("Location:../../vista/SP/error.php");
            }
        } else {
            header("Location:../../vista/SP/noseleccion.php");
        }
    }

    mysqli_begin_transaction($conn, MYSQLI_TRANS_START_READ_WRITE);

    try {
        if (isset($_POST['submit_dpi'])) {
            echo "Llamando a uploadFile para declaración<br>";
            uploadFile('dpinicial', 'dpinicial', 'acuse', 'fechaDeEntrega', $idEmp, $conn);
        }

        if (isset($_POST['submit_dpm'])) {
            echo "Llamando a uploadFile para declaración<br>";
            uploadFile('dpmodificacion', 'dpmayo', 'acuse', 'fechaDeEntrega', $idEmp, $conn);
        }

        if (isset($_POST['submit_dpc'])) {
            echo "Llamando a uploadFile para declaración<br>";
            uploadFile('dptermino', 'dpconclusion', 'acuse', 'fechaDeEntrega', $idEmp, $conn);
        }

        if (isset($_POST['submit_entrega'])) {
            echo "Llamando a uploadFile para entrega<br>";
            uploadFile('entrega', 'entrega', 'acuseE', 'feEn', $idEmp, $conn);
        }

        if (isset($_POST['submit_recepcion'])) {
            echo "Llamando a uploadFile para recepción<br>";
            uploadFile('recepcion', 'recepcion', 'acuseR', 'feREnt', $idEmp, $conn);
        }

        mysqli_commit($conn);
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "Error: " . $e->getMessage() . "<br>";
    }
}
?>




