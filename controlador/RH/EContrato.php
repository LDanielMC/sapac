<?php
// session_start();

// if (!isset($_SESSION['usuario'])) {
//     header("Location: ../../index.php");
//     exit();
// }
?>
<?php
include '../../modelo/db.php';

if (isset($_GET['idEmp']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $idEmp = $_GET['idEmp'];
    $rfc = $_POST['rfc'];
    $departamento = $_POST['departamento'];
    $puesto = $_POST['puesto'];
    $sueldo = $_POST['sueldo'];
    $estatus = $_POST['estatus'];
    
    //Actualizar tabla contrato
    $query = "UPDATE contrato 
              SET rfc = ?, departamento = ?, puesto = ?, sueldo = ?, estatus = ?
              WHERE idEmp = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssi", $rfc, $departamento, $puesto, $sueldo, $estatus, $idEmp);

    if ($stmt->execute()) {
        echo "Información actualizada correctamente.";
        header("Location:../../vista/RH/homeRH.php");
    } else {
        echo "Error al actualizar la información.";
    }
    $stmt->close();
} else {
    echo "Datos incompletos o método no permitido.";
}
$conn->close();
?>
