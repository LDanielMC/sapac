<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
    exit();
}
?>

<?php include '../headers/headerSP.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial DP</title>

    <link href="https://fonts.cdnfonts.com/css/biennale" rel="stylesheet">
    <link rel="stylesheet" href="../css/stylesSP.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>

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

<div class="container">
<h1>Historial Declaraciones Patrimoniales</h1>
    
    <!-- Botón de regreso al Home -->
    <a href="homeSP.php" class="btn btn-secondary mb-4">
        <i class="bi bi-arrow-left-circle"></i> Volver al Inicio
    </a>

    <hr><br><br>
    
    <!-- Campo de búsqueda -->
    <input type="text" id="searchInput" class="form-control mb-3" placeholder="Buscar Declaración...">
    
    <fieldset>
    <h3>Inicio</h3>
    <div class="table-responsive">
        <table class="table table-hover" style="font-size: 15px;" id="tableDP">
            <thead>
                <tr>
                    <th>FOLIO</th>
                    <th>ACUSE</th>
                    <th>ESTADO</th>
                    <th>FECHA DE ENTREGA</th>
             
                </tr>
            </thead>
            <tbody>
                <?php 
                include('../../modelo/db.php');
                
                $idEmp = $_SESSION['idEmp'];
                $info = $conn->query ("SELECT * FROM dpinicial WHERE idEmp = $idEmp;");

                while($datos = $info->fetch_object()) { ?>
                        <tr>
                        <td><?= $datos->id_DPI ?></td>
                        <td>
                            <?php if ($datos->acuse !== null): ?>
                                <a href="<?= $datos->acuse ?>" target="_blank" class="document-link">
                                    <i class="fas fa-file-alt"></i> Ver documento
                                </a>
                            <?php endif; ?>
                        </td>
                        <td><?= $datos->estado ?></td>
                        <td><?= $datos->fechaDeEntrega ?></td>
                        
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</fieldset>
<br>

<fieldset>
    <h3>Modificación</h3><br>
    <div class="table-responsive">
        <table class="table table-hover" style="font-size: 15px;" id="tableDP">
            <thead>
                <tr>
                    <th>FOLIO</th>
                    <th>ACUSE</th>
                    <th>ESTADO</th>
                    <th>FECHA DE ENTREGA</th>
             
                </tr>
            </thead>
            <tbody>
                <?php 
                $info2 = $conn->query ("SELECT * FROM dpmayo WHERE idEmp = $idEmp;");

                while($datos2 = $info2->fetch_object()) { ?>
                        <tr>
                        <td><?= $datos2->id_DPM ?></td>
                        <td>
                            <?php if ($datos2->acuse !== null): ?>
                                <a href="<?= $datos2->acuse ?>" target="_blank" class="document-link">
                                    <i class="fas fa-file-alt"></i> Ver documento
                                </a>
                            <?php endif; ?>
                        </td>
                        <td><?= $datos2->estado ?></td>
                        <td><?= $datos2->fechaDeEntrega ?></td>
                        
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</fieldset>

<br>
<fieldset>
    <h3>Conclusión</h3> <br>
    <div class="table-responsive">
        <table class="table table-hover" style="font-size: 15px;" id="tableDP">
            <thead>
                <tr>
                    <th>FOLIO</th>
                    <th>ACUSE</th>
                    <th>ESTADO</th>
                    <th>FECHA DE ENTREGA</th>
             
                </tr>
            </thead>
            <tbody>
                <?php 
                $info3 = $conn->query ("SELECT * FROM dpconclusion WHERE idEmp = $idEmp;");

                while($datos3 = $info3->fetch_object()) { ?>
                        <tr>
                        <td><?= $datos3->id_DPC ?></td>
                        <td>
                            <?php if ($datos3->acuse !== null): ?>
                                <a href="<?= $datos3->acuse ?>" target="_blank" class="document-link">
                                    <i class="fas fa-file-alt"></i> Ver documento
                                </a>
                            <?php endif; ?>
                        </td>
                        <td><?= $datos3->estado ?></td>
                        <td><?= $datos3->fechaDeEntrega ?></td>
                        
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</fieldset>

</div>
<script src="../../controlador/SP/search.js"></script>
</body>
</html>



