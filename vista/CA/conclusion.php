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
<?php include '../headers/headerCA.php'; ?> <br>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial DP</title>

    <!-- <link href="https://fonts.cdnfonts.com/css/biennale" rel="stylesheet"> -->
    <link rel="stylesheet" href="../css/stylesSP.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .table-different {
            display: none; /* Oculta la tabla adicional inicialmente */
        }
    </style>
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
        <h1>Declaraciones Patrimoniales Conclusión</h1>

        <!-- Botón que muestra otra tabla -->
        <button id="toggleTableBtn" class="btn btn-secondary mb-4">
            <i class="bi bi-arrow-left-circle"></i> Ver Sin entregar
        </button>

        <hr><br><br>
        
        <!-- Tabla inicial -->
        <fieldset id="tableContainer1">
            <h3>Inicio</h3>
            <div class="table-responsive">
                <table class="table table-hover" style="font-size: 15px;" id="tableDP">
                <thead>
                    <tr>
                        <th>FOLIO</th>
                        <th>ACUSE</th>
                        <th>ESTADO</th>
                        <th>FECHA DE ENTREGA</th>
                        <th>MÁS INFORMACIÓN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    include('../../modelo/db.php');
                    
                    $info = $conn->query ("SELECT * FROM dpconclusion WHERE estado = 'Pendiente';");

                    while($datos = $info->fetch_object()) { ?>
                        <tr>
                            <td><?= $datos->id_DPC ?></td>
                            <td>
                                <?php if ($datos->acuse !== null): ?>
                                    <a href="<?= $datos->acuse ?>" target="_blank" class="document-link">
                                        <i class="fas fa-file-alt"></i> Ver documento
                                    </a>
                                <?php endif; ?>
                            </td>
                            <td><?= $datos->estado ?></td>
                            <td><?= $datos->fechaDeEntrega ?></td>
                            <td>
                                <a href="detalleDC.php?id=<?= $datos->id_DPC ?>" class="btn btn-info">
                                    <i class="bi bi-info-circle"></i> Detalles
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
                </table>
            </div>
        </fieldset>

        <!-- Tabla Sin Entregar -->
        <fieldset id="tableContainer2" class="table-different">
        <div class="d-flex justify-content-between align-items-center">
            <h3 style="margin-left: 20px">Sin Entregar</h3>
            <!-- Botón para enviar correos -->
            <button id="sendEmailsBtn" class="btn btn-primary" style="margin: 10px">
                <i class="bi bi-envelope-fill"></i> Enviar correos de recordatorio
            </button>
        </div><hr>
            <div class="table-responsive">
                <table class="table table-hover" style="font-size: 15px;" id="tableDP2">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NOMBRE</th>
                            <th>APELLIDO P</th>
                            <th>TELÉFONO</th>
                            <th>ESTADO</th>
                            <th>CORREO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $infoOther = $conn->query("SELECT e.idEmp, e.nombre, e.apellidoP, e.telefono,
                        e.correo, d.estado FROM bdsapac.empleado e
                        JOIN bdsapac.dpconclusion d ON e.idEmp = d.idEmp WHERE d.estado = 'Sin entregar';");

                        while($datos = $infoOther->fetch_object()) { ?>
                            <tr>
                                <td><?= $datos->idEmp ?></td>
                                <td><?= $datos->nombre ?></td>
                                <td><?= $datos->apellidoP ?></td>
                                <td><?= $datos->telefono ?></td>
                                <td><?= $datos->estado ?></td>
                                <td class="email-column"><?= $datos->correo ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </fieldset>

    </div>

    <script src="../../controlador/CA/htablaC.js"> </script>
</body>
</html>