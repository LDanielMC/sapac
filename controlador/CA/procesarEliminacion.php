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
    if (isset($_POST['usuarios']) && !empty($_POST['usuarios'])) {
        $usuarios = $_POST['usuarios'];

        // Preparar la eliminación únicamente de la tabla `perfiles`
        foreach ($usuarios as $idEmp) {
            // Obtener el `idCont` asociado al `idEmp`
            $queryIdCont = "SELECT idCont FROM contrato WHERE idEmp = $idEmp";
            $result = $conn->query($queryIdCont);

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $idCont = $row['idCont'];

                // Eliminar el perfil asociado al `idCont`
                $conn->query("DELETE FROM perfiles WHERE idCont = $idCont");
            }
        }

        $_SESSION['mensaje'] = "Perfiles eliminados correctamente.";
    } else {
        $_SESSION['mensaje'] = "No se seleccionó ningún usuario.";
    }
}
header("Location: ../../vista/CA/eliminarUsuarios.php");
exit();
?>
