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
    <h1 class="text-center">Menú principal</h1>
    <br>
    <div class="container">
        <div class="menu">
            <a href="MenuDP.php"><img src="../img/document.png" class="icon"> <p>Declaraciones <br> Patrimoniales</p> </a>
            
        </div>

        <div class="menu">
            <a href="entregas.php"><img src="../img/right-arrow.png" class="icon"> <p>Entregas</p> </a>
            
        </div>

        <div class="menu">
            <a href="recepcion.php"><img src="../img/left-arrow.png" class="icon"> <p>Recepción</p> </a>
            
        </div>

        <div class="menu">
            <a href="Qrecibidas.php"><img src="../img/buzon.png" class="icon"> <p>Quejas<br>recibidas</p></a>
            
        </div>

        <div class="menu">
            <a href="investigaciones.php"><img src="../img/inv.png" class="icon"><p>Investigaciones</p></a>
            
        </div>

        <div class="menu">
            <a href="bitacora.php"><img src="../img/historial.png" class="icon"><p>Bitácora RH</p></a>
            
        </div>
        <div class="menu">
            <a href="indxBD.php"><img src="../img/database.png" class="icon"><p>Base de datos</p></a>
            
        </div>

        <div class="menu">
            <a href="eliminarUsuarios.php"><img src="../img/elim.png" class="icon"><p>Eliminar Usuarios</p></a>
            
        </div>

        <div class="menu">
            <a href="../SP/homeSP.php" target="_blank"><img src="../img/subir.png" class="icon"><p>Subir mis archivos</p></a>            
        </div>


    </div>
</body>
</html>