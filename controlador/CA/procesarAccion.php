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
include '../../modelo/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idQueja = $_POST['idQueja'];
    $accion = $_POST['accion'];

    if ($accion === 'Cancelar') {
        // Actualizar el estatus a "Cancelada"
        $updateQuery = "UPDATE buzon SET estatus = 'Cancelada' WHERE idB = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param('i', $idQueja);
        if ($stmt->execute()) {
            echo "<script>alert('Queja cancelada correctamente.'); window.location.href='../../vista/CA/Qrecibidas.php';</script>";
        } else {
            echo "<script>alert('Error al cancelar la queja.'); history.back();</script>";
        }
    } elseif ($accion === 'Iniciar') {
        // Redirigir a otra página para llenar el formulario
        header("Location: ../../vista/CA/inv.php?idB=$idQueja");
        exit();
    }
}
?>

<!-- este es cuando se inica una investigación y se 
cambia el estatus como las eliminaciones logicas  -->