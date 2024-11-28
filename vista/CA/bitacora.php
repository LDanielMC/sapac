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
<?php  include '../../modelo/db.php'?>
<?php  include '../../vista/headers/headerCA.php'?><br>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bitacora RH</title>
    
    <link href="https://fonts.cdnfonts.com/css/biennale" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
<div class="container">

    <div class="container">

        <h1 class="text-center">Bitácora de RH</h1>
    </div> 
    
    <!-- Campo de búsqueda -->
    <input type="text" id="searchCA" class="form-control mb-3" placeholder="Buscar...">
    

    <fieldset>
        <div class="table-responsive">
            <table class="table table-hover" style="font-size: 15px;" id="CASearch"> 
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Suceso</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "select * from historial";
                        $exec = mysqli_query($conn,$sql);
                        while($rows = mysqli_fetch_array($exec)){
                    ?>        
                            <tr>
                                <th> <?php echo $rows ['idH']; ?> </th>
                                <th> <?php echo $rows ['texto']; ?> </th>
                            </tr>
                    <?php } ?>
                </tbody> 
            </table>    
        </div>
    </fieldset>

    <!-- Enlace al archivo JavaScript -->
<script src="../../controlador/CA/search2.js"></script>
</body>
</html>