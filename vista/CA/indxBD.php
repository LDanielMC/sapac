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
<?php include '../headers/headerCA.php';?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backup y Restore</title>
    <!-- Enlace a Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>
<body>
        <nav class="navbar navbar-light bg-light px-3">
            <div class="container-fluid">
                <!-- Botón para ir al Home -->
                <a href="homeCA.php" class="btn btn-outline-primary me-2">
                    <i class="bi bi-house-door"></i> Home
                </a>
                <!-- Botón para regresar -->
                <button onclick="window.history.back();" class="btn btn-outline-secondary me-auto">
                    <i class="bi bi-arrow-left"></i> Regresar
                </button>
                <span class="navbar-text ms-auto" style="font-size: 20px;">
                    <i class="bi bi-person-circle"></i> <?php echo $_SESSION['usuario']; ?>
                </span>
                <a href="../../controlador/logout.php" class="btn btn-outline-danger ms-2">
                    <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                </a>
            </div>
        </nav>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Copia de Seguridad y Restauración</h1>
        <br><br><br>

        <div class="mb-4">
            <a href="../../modelo/Backup.php" class="btn btn-success w-100">Realizar copia de seguridad</a>
        </div>
        <form action="../../modelo/Restore.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="restoreFile" class="form-label">Cargar archivo SQL</label>
                <input type="file" name="restoreFile" id="restoreFile" class="form-control" accept=".sql" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Restaurar</button>
        </form>
    </div>
    <!-- Enlace a Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
