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
include '../../modelo/db.php';  // Asegúrate de que esta ruta sea correcta
header('Content-Type: application/json');

$query = "CALL obtenerInvestigadores()";
$result = mysqli_query($conn, $query);

if (!$result) {
    die(json_encode(['error' => 'Error en la consulta: ' . mysqli_error($conn)]));
}

$investigadores = [];
while ($row = mysqli_fetch_assoc($result)) {
    $investigadores[] = $row;
}

mysqli_close($conn);

echo json_encode($investigadores);
?>
