<?php  
include '../../modelo/db.php';

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

$hoy = date("Y-m-d");
$nom1 = isset($_POST['nombre']) ? $_POST['nombre'] : null;
$tel = isset($_POST['telefono']) ? $_POST['telefono'] : null;
$domi = $_POST['domicilio'];
$mtv = $_POST['motivo'];
$hs = $_POST['hechos'];
$especificacion = isset($_POST['espe']) ? $_POST['espe'] : null;

// Validar si hay pruebas
$prueba = !empty($especificacion) ? "Sí" : "No";

$sql = "INSERT INTO buzon (feBu, nombreCompleto, telefono, domicilio, motivo, hechos, pruebas, especificacion) 
VALUES ('$hoy', '$nombre', '$telefono', '$domicilio', '$motivo', '$hechos', '$prueba', '$especificacion')";

$execute = mysqli_query($conn, $sql);
echo "Se esta rtabajando la insercion";

sleep(2);
header("Location: ../../vista/buzon/quejas.html?status=success");

exit();
?>
