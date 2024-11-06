<?php
// session_start();

// if (!isset($_SESSION['usuario'])) {
//     header("Location: ../../index.php");
//     exit();
// }
?>
<?php
include '../../modelo/db.php';

if (isset($_GET['idEmp']) && !empty($_POST)) {
    $idEmp = $_GET['idEmp'];
    
    // Recibir los datos del formulario
    $nombre = $_POST['nombre'];
    $apellidoP = $_POST['apellidoP'];
    $apellidoM = $_POST['apellidoM'];
    $fechaNacimiento = $_POST['fechaNacimiento'];
    $sexo = $_POST['sexo'];
    $estadoCivil = $_POST['estadoCivil'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $domicilio = $_POST['domicilio'];

    //Actualizar en labase de datos
    $query = "UPDATE empleado 
              SET nombre = ?, apellidoP = ?, apellidoM = ?, feNac = ?, sexo = ?, estadoCivil = ?, telefono = ?, correo = ?, domicilio = ? 
              WHERE idEmp = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssssssi", $nombre, $apellidoP, $apellidoM, $fechaNacimiento, $sexo, $estadoCivil, $telefono, $correo, $domicilio, $idEmp);

    if ($stmt->execute()) {
        echo "Información actualizada correctamente.";
        header("Location:../../vista/RH/homeRH.php");
        exit;
    } else {
        echo "Error al actualizar la información del empleado.";
    }

    $stmt->close();
} else {
    echo "Datos incompletos o id de empleado no especificado.";
}
$conn->close();
?>


