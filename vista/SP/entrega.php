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

<div class="container">

    <h1>Historial Entrega</h1>

    
        <!-- Botón de regreso al Home -->
        <a href="homeSP.php" class="btn btn-secondary mb-4">
        <i class="bi bi-arrow-left-circle"></i> Volver al Inicio
    </a>

    <hr><br><br>
    
    <!-- Campo de búsqueda -->
    <input type="text" id="searchInput" class="form-control mb-3" placeholder="Buscar entrega...">
    
    <fieldset>
    <div class="table-responsive">
        <table class="table table-hover" style="font-size: 15px;" id="employeeTable">
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
                $info = $conn->query ("SELECT * FROM entrega WHERE idEmp = $idEmp;");

                while($datos = $info->fetch_object()) { ?>
                        <tr>
                        <td><?= $datos->idE ?></td>
                        <td>
                            <?php if ($datos->acuseE !== null): ?>
                                <a href="<?= $datos->acuseE ?>" target="_blank" class="document-link">
                                    <i class="fas fa-file-alt"></i> Ver documento
                                </a>
                            <?php endif; ?>
                        </td>
                        <td><?= $datos->estado ?></td>
                        <td><?= $datos->feEn ?></td>
                        
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    </fieldset>
    </form>
</div>
    
</body>
</html>