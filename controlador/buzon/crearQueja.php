
<?php  
include '../../modelo/db.php';

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}
date_default_timezone_set('America/Mexico_City');

$estatus = "Sin revisar";
$hoy = date("Y-m-d");
$nom1 = isset($_POST['nombre']) ? $_POST['nombre'] : null;
$tel = isset($_POST['telefono']) ? $_POST['telefono'] : null;
$domi = isset($_POST['domicilio']) ? $_POST['domicilio'] : null;
$cuen = isset($_POST['cuenta']) ? $_POST['cuenta'] : null;
$mtv = isset($_POST['motivo']) ? $_POST['motivo'] : null;
$nomrp = isset($_POST['rp']) ? $_POST['rp'] : null;
$hs = isset($_POST['hechos']) ? $_POST['hechos'] : null;
$especificacion = isset($_FILES['espe']) ? $_FILES['espe'] : null;

// Validar si hay pruebas
$prueba = ($especificacion && !empty($especificacion['name'][0])) ? "Si" : "No";

$uploadDirectory = "../../uploads/EvidenciasQuejas/";
$filePaths = [];
$filePathsString = null; // Inicializar la variable para evitar errores

if ($prueba === "Si") {
    // Verificar si se subieron archivos
    foreach ($especificacion['tmp_name'] as $index => $tmpName) {
        if (!empty($tmpName)) {
            $originalFileName = $especificacion['name'][$index];
            $newFileName = date('Ymd_His') . "_" . basename($originalFileName);
            $destinationPath = $uploadDirectory . $newFileName;

            // Intentar mover el archivo y verificar si se subió correctamente
            if (move_uploaded_file($tmpName, $destinationPath)) {
                $filePaths[] = $newFileName; // Guardar solo el nombre del archivo
            } else {
                echo "Error al subir el archivo: " . $originalFileName . "<br>";
            }
        }
    }

    // Convertir el array de rutas a una cadena separada por comas
    if (!empty($filePaths)) {
        $filePathsString = implode(',', $filePaths);
    }
}

// Preparar y ejecutar la consulta
if ($prueba === "Si" && $filePathsString !== null) {
    $stmt = $conn->prepare("INSERT INTO buzon (estatus, feBu, nombreCompleto, telefono, domicilio, cuenta, motivo, nomCompResp, hechos, pruebas, especificacion) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $estatus, $hoy, $nom1, $tel, $domi, $cuen, $mtv, $nomrp, $hs, $prueba, $filePathsString);
} else {
    $stmt = $conn->prepare("INSERT INTO buzon (estatus, feBu, nombreCompleto, telefono, domicilio, cuenta, motivo, nomCompResp, hechos, pruebas) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $estatus, $hoy, $nom1, $tel, $domi, $cuen, $mtv, $nomrp, $hs, $prueba);
}

// Ejecutar la consulta
if ($stmt->execute()) {
    echo "<script>alert('¡Queja enviada correctamente!'); window.location.href='../../vista/buzon/quejas.html';</script>";
} else {
    echo "<script>alert('Error al enviar la queja: " . $stmt->error . "'); history.back();</script>";
}

$stmt->close();
$conn->close();
?>
