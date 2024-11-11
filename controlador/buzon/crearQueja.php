<?php  
include '../../modelo/db.php';

    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    $hoy = date("Y-m-d"); //zona horaria
    $nom1 = isset($_POST['nombre']) ? $_POST['nombre'] : null;
    $tel = isset($_POST['telefono']) ? $_POST['telefono'] : null;
    $domi = $_POST['domicilio'];
    $cuen = $_POST['cuenta'];
    $mtv = $_POST['motivo'];
    $nomrp = $_POST['rp'];
    $hs = $_POST['hechos'];
    $especificacion = isset($_POST['espe']) ? $_POST['espe'] : null;

    // Validar si hay pruebas
    $prueba = !empty($especificacion) ? "Sí" : "No";

    $sql = "INSERT INTO buzon (feBu, nombreCompleto, telefono, domicilio, cuenta, motivo, nomCompResp , hechos, pruebas, especificacion) 
    VALUES ('$hoy', '$nom1', '$tel', '$domi', '$cuen' , '$mtv', '$nomrp' , '$hs', '$prueba', '$especificacion')";

    $execute = mysqli_query($conn, $sql);

    sleep(2);
    header("Location: ../../vista/buzon/quejas.html?status=success");

    exit();
?>
