<?php
// session_start();

// if (!isset($_SESSION['usuario'])) {
//     header("Location: ../../index.php");
//     exit();
// }
?>

<?php include '../headers/headerRH.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Recursos Humanos</title>

    <link href="https://fonts.cdnfonts.com/css/biennale" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

    <!-- Barra de navegación superior -->
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
    <h1>Gestión de Empleados</h1>
    
    <!-- Campo de búsqueda -->
    <!-- <input type="text" id="searchInput" class="form-control mb-3" placeholder="Buscar empleado..."> -->
    
    <a href="RegistroE.php" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Registrar Empleado
    </a>
    <form name="frmempleado" id="frmempleado" method="POST" action="../../controlador/RH/REmpleado.php">
    <fieldset>
    <div class="table-responsive">
        <table class="table table-hover" style="font-size: 15px;" id="employeeTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NOMBRE</th>
                    <th>APELLIDO P</th>
                    <th>APELLIDO M</th>
                    <th>DEPARTAMENTO</th>
                    <th>PUESTO</th>
                    <th>USUARIO</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                include('../../modelo/db.php');
                $info = $conn->query("SELECT empleado.idEmp, nombre, apellidoP, apellidoM, departamento, puesto, usuarios
                FROM empleado 
                INNER JOIN contrato ON empleado.idEmp = contrato.idEmp 
                INNER JOIN perfiles ON contrato.idCont = perfiles.idCont 
                WHERE contrato.estatus ='Activo';");

                while($datos = $info->fetch_object()) { ?>
                        <tr>
                        <td><?= $datos->idEmp ?></td>
                        <td onclick="window.location.href='EditarDP.php?idEmp=<?= $datos->idEmp ?>'"><?= $datos->nombre ?></td>
                        <td onclick="window.location.href='EditarDP.php?idEmp=<?= $datos->idEmp ?>'"><?= $datos->apellidoP ?></td>
                        <td onclick="window.location.href='EditarDP.php?idEmp=<?= $datos->idEmp ?>'"><?= $datos->apellidoM ?></td>
                        <td onclick="window.location.href='EditarC.php?idEmp=<?= $datos->idEmp ?>'"><?= $datos->departamento ?></td>
                        <td onclick="window.location.href='EditarC.php?idEmp=<?= $datos->idEmp ?>'"><?= $datos->puesto ?></td>
                        <td onclick="window.location.href='EditarP.php?idEmp=<?= $datos->idEmp ?>'"><?= $datos->usuarios ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    </fieldset>
    </form>
</div>

<!-- Enlace al archivo JavaScript -->
<script src="../../controlador/RH/search.js"></script>
</body>
</html>
