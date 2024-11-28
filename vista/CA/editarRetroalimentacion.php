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

// Obtener el ID de la investigación
$idI = $_GET['idI'];

// Consultar los datos de la investigación
$sql = "SELECT * FROM investigacion WHERE idI = $idI AND estatus = 'En proceso'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
} else {
    echo "<script>alert('No se puede editar esta investigación.'); window.location.href='investigaciones.php';</script>";
    exit;
}

// Actualizar la retroalimentación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $retroalimentacion = mysqli_real_escape_string($conn, $_POST['retroalimentacion']);

    $updateSql = "UPDATE investigacion SET retroalimentacion = '$retroalimentacion' WHERE idI = $idI";
    if (mysqli_query($conn, $updateSql)) {
        echo "<script>alert('Retroalimentación actualizada.'); window.location.href='investigaciones.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar la retroalimentación.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Retroalimentación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Editar Retroalimentación</h1>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="retroalimentacion" class="form-label">Retroalimentación</label>
                <textarea name="retroalimentacion" id="retroalimentacion" class="form-control" rows="5"><?php echo htmlspecialchars($row['retroalimentacion']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-success">Guardar</button>
            <a href="investigaciones.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
