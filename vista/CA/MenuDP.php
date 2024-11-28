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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comisaria</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/stylesCA.css">
</head><br>
<body>
    <!-- Para cerrar la sesion -->
    <nav class="navbar navbar-light bg-light px-3">
            <div class="container-fluid">
                <span class="navbar-text ms-auto" style="font-size: 20px;">
                    <i class="bi bi-person-circle" ></i> <?php echo $_SESSION['usuario']; ?>
                </span>
                <a href="../../controlador/logout.php" class="btn btn-outline-danger ms-2">
                    <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                </a>
            </div>
    </nav> 
    <h1 class="text-center">Declaraciones Patrimoniales</h1>
    <br><br><br><br>
    <div class="container">
        <div class="menu">
            <a href="DA.php"><img src="../img/document.png" class="icon"> <p>INICIAL</p> </a>
            
        </div>

        <div class="menu">
            <a href="modificacion.php"><img src="../img/modificacion.png" class="icon"> <p>MODIFICACIÓN</p> </a>
            
        </div>

        <div class="menu">
            <a href="conclusion.php"><img src="../img/conclusion.png" class="icon"> <p>CONCLUSIÓN</p> </a>
            
        </div>

    </div>
</body>
</html>
