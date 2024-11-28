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

// Verificar si la conexión a la base de datos es válida
if (!$conn) {
    die('Error al conectar con la base de datos: ' . mysqli_connect_error());
}

// Verificar si el parámetro idB está presente en la URL
if (isset($_GET['idB'])) {
    $idBeneficiario = $_GET['idB'];

    // Consultas para actualizar el estatus
    $sql1 = "UPDATE buzon SET estatus = 'Finalizado' WHERE idB = ?";
    $sql2 = "UPDATE investigacion SET estatus = 'Finalizado' WHERE idB = ?";

    // Preparar y ejecutar la primera consulta
    if ($stmt1 = mysqli_prepare($conn, $sql1)) {
        mysqli_stmt_bind_param($stmt1, "i", $idBeneficiario);

        if (mysqli_stmt_execute($stmt1)) {
            // Consulta 1 exitosa, proceder con la segunda
            if ($stmt2 = mysqli_prepare($conn, $sql2)) {
                mysqli_stmt_bind_param($stmt2, "i", $idBeneficiario);

                if (mysqli_stmt_execute($stmt2)) {
                    echo 'success'; // Ambas actualizaciones fueron exitosas
                } else {
                    echo 'Error al ejecutar la consulta 2: ' . mysqli_stmt_error($stmt2);
                }

                mysqli_stmt_close($stmt2);
            } else {
                echo 'Error al preparar la consulta 2: ' . mysqli_error($conn);
            }
        } else {
            echo 'Error al ejecutar la consulta 1: ' . mysqli_stmt_error($stmt1);
        }

        mysqli_stmt_close($stmt1);
    } else {
        echo 'Error al preparar la consulta 1: ' . mysqli_error($conn);
    }
} else {
    echo 'Error: No se recibió el idB.';
}

// Cerrar la conexión
mysqli_close($conn);
?>