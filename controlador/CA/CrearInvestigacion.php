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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $estatus = $_POST['estatus'];
    $responsable = $_POST['responsable'];
    $retroalimentacion = $_POST['retroalimentacion'];
    $idB = $_POST['idB'];
    
    // Fecha de inicio es la fecha actual
    $feInicio = date('Y-m-d');
    $feTermino = ($estatus == 'Finalizada') ? $feInicio : null; // Si el estatus es "Finalizada", se guarda la fecha actual en feTermino

    // Verificar que todas las claves necesarias están presentes
    if (empty($responsable)) {
        echo "Error: responsable no está definido.";
        exit;
    }

    // Iniciar una transacción para asegurarse de que ambas operaciones se completen o ninguna
    $conn->begin_transaction();

    try {
        // Insertar en la tabla Investigacion
        $query = "
        INSERT INTO Investigacion (titulo, feInicio, feTermino, responsable, estatus, retroalimentacion, idB) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssssi", $titulo, $feInicio, $feTermino, $responsable, $estatus, $retroalimentacion, $idB);

        if (!$stmt->execute()) {
            throw new Exception("Error al insertar en Investigacion: " . $stmt->error);
        }

        // Actualizar el estatus en la tabla buzon
        $updateQuery = "UPDATE buzon SET estatus = 'En proceso' WHERE idB = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("i", $idB);

        if (!$updateStmt->execute()) {
            throw new Exception("Error al actualizar el estatus en buzon: " . $updateStmt->error);
        }

        // Confirmar la transacción
        $conn->commit();

        echo "<script type='text/javascript'>
        alert('Investigación creada y estatus actualizado con éxito.');
        window.location.href = '../../vista/CA/homeCA.php'; // Redirige a la página de investigaciones
        </script>";

    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conn->rollback();
        echo "<script type='text/javascript'>alert('Error: " . $e->getMessage() . "');</script>";
    }

    $stmt->close();
    $updateStmt->close();
    $conn->close();
}
?>
