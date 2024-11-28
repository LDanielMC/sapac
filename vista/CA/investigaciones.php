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
    <title>Quejas Recibidas</title>

    <link rel="stylesheet" href="../css/stylesdetalle.css">
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
        <h1 class="text-center">Investigaciones</h1>
    </div> 

    <div class="container">  
        <br>
        <form name="frm" id="frm" method="post">
            <!-- Boton de redirección para ver las Finalizadas -->
            <button type="button" class="btn btn-success" onclick="window.location.href='../../Controlador/CA/convertirpdf/reporteInv.php'">Generar Reporte</button>
        </form>
    </div> 

    <div class="container">
        <!-- Campo de búsqueda -->
        <input type="text" id="searchCA" class="form-control mb-3" placeholder="Buscar investigacion...">

        <fieldset>
            <div class="table-responsive">
                <table class="table table-hover" style="font-size: 12px;" id="CASearch">
                    <thead>
                        <tr>
                            <th>ID Investigacion</th>
                            <th>ID Queja</th>
                            <th>Titulo</th>
                            <th>Hechos</th>
                            <th>Retroalimentación</th>
                            <th>Responsable</th>
                            <th>Estatus</th>
                            <th>Finalizar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "CALL obtenerDatos()";
                            $exec = mysqli_query($conn,$sql);
                            while($rows = mysqli_fetch_array($exec)){
                        ?>        
                                <tr>
                                    <th> <?php echo $rows ['idI']; ?> </th>
                                    <th> <?php echo $rows ['idB']; ?> </th>
                                    <th> <?php echo $rows ['titulo']; ?> </th>
                                    <th> <?php echo $rows ['hechos']; ?> </th>
                                    <th>
                                        <?php if ($rows['estatus'] == 'En proceso') { ?>
                                            <a href="editarRetroalimentacion.php?idI=<?php echo $rows['idI']; ?>" class="btn btn-primary btn-sm">
                                                Editar
                                            </a>
                                        <?php } else { ?>
                                            <a href="verRetroalimentacion.php?idI=<?php echo $rows['idI']; ?>" class="btn btn-secondary btn-sm">
                                                Ver
                                            </a>
                                        <?php } ?>
                                    </th>
                                    <th> <?php echo $rows ['responsable']; ?> </th>
                                    <th> <?php echo $rows ['estatus']; ?> </th>
                                    
                                    <th> 
                                        <?php if($rows['estatus'] != 'Finalizado') { ?>
                                            <!-- Imagen de "Finalizar" -->
                                            <img src="../img/end.png" alt="Finalizar" class="finalizar-btn" onclick="peticion(<?php echo $rows['idB']; ?>)" style="cursor: pointer;">
                                        <?php } ?>
                                    </th>
                                </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </fieldset>
    </div>
    <script src="../../controlador/CA/search2.js"></script>

    <!-- Script para manejar la acción de finalizar con AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function peticion(idB){
            var idBeneficiario = idB //ID del beneficiario
            // Enviar solicitud AJAX para actualizar el estatus
            $.ajax({
                url: '../../controlador/CA/finalizar.php?idB='+idBeneficiario, // El archivo PHP que se encarga de actualizar el estatus
                type: 'GET',
                data: { idB: idBeneficiario }, // Pasar solo el ID del beneficiario
                success: function(response) {
                    // Si la actualización es exitosa, actualizar el estatus en la tabla sin recargar la página
                    if(response == 'success') {
                        alert('La queja ha sido finalizada.');
                        location.reload(); // Recargar la página para mostrar el cambio
                    } else {
                        alert('Hubo un error al finalizar la queja.');
                    }
                },
                error: function() {
                    alert('Error de conexión.');
                    
                }
            });
        }

        $(document).ready();
    </script>
</body>
</html>