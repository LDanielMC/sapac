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
$sql = "SELECT * FROM investigacion WHERE idI = $idI";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
} else {
    echo "<script>alert('No se encontró la investigación.'); window.location.href='investigaciones.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Retroalimentación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Retroalimentación</h1>
        <div class="mb-3">
            <label for="retroalimentacion" class="form-label">Retroalimentación</label>
            <textarea id="retroalimentacion" class="form-control" rows="5" readonly><?php echo htmlspecialchars($row['retroalimentacion']); ?></textarea>
        </div>
        <a href="investigaciones.php" class="btn btn-secondary">Volver</a>
    </div>
</body>
</html>
