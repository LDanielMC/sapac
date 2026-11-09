<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
    exit();
}
// Verificar si pertenece al departamento de Recursos Humanos
if ($_SESSION['departamento'] !== 'Recursos Humanos') {
    header("Location: ../../index.php");
    exit();
}
?>

<?php
include('../../modelo/db.php');

if (isset($_GET['idEmp']) && isset($_POST['confirmarContrasena'])) {
    $idEmp = $_GET['idEmp'];
    $nuevaContrasena = password_hash($_POST['confirmarContrasena'], PASSWORD_DEFAULT);
    
    // Actualiza la contraseña en la base de datos
    $query = "UPDATE perfiles 
              INNER JOIN contrato ON perfiles.idCont = contrato.idCont 
              INNER JOIN empleado ON contrato.idEmp = empleado.idEmp 
              SET perfiles.contrasena = ? 
              WHERE empleado.idEmp = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $nuevaContrasena, $idEmp);

    if ($stmt->execute()) {
        echo "Contraseña actualizada exitosamente.";
        header("Location:../../vista/RH/homeRH.php");
    } else {
        echo "Error al actualizar la contraseña.";
    }
    $stmt->close();
} else {
    echo "ID de empleado o nueva contraseña no especificada.";
}
$conn->close();
?>
