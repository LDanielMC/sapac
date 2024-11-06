<?php
// session_start();

// if (!isset($_SESSION['usuario'])) {
//     header("Location: ../../index.php");
//     exit();
// }
?>

<?php
include('../../modelo/db.php');

// Verifica si se ha pasado el idEmp
if (isset($_GET['idEmp'])) {
    $idEmp = $_GET['idEmp'];
    
    // Obtener información del empleado para editar
    $query = "SELECT empleado.*, contrato.*, perfiles.usuarios, perfiles.contrasena 
          FROM empleado 
          INNER JOIN contrato ON empleado.idEmp = contrato.idEmp 
          INNER JOIN perfiles ON contrato.idCont = perfiles.idCont 
          WHERE empleado.idEmp = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idEmp);
    $stmt->execute();
    $result = $stmt->get_result();
    $datos = $result->fetch_object();

    // Verifica si se encontró el empleado
    if (!$datos) {
        echo "Empleado no encontrado.";
        exit;
    }
} else {
    echo "ID de empleado no especificado.";
    exit;
}

// Aquí puedes crear un formulario para editar la información del empleado usando $datos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Empleado</title>
    <link href="https://fonts.cdnfonts.com/css/biennale" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>

        <!-- Barra de navegación superior -->
        <!-- <nav class="navbar navbar-light bg-light px-3">
        <div class="container-fluid">
            <span class="navbar-text ms-auto" style="font-size: 20px;">
                <i class="bi bi-person-circle" ></i> <?php echo $_SESSION['usuario']; ?>
            </span>
            <a href="../../controlador/logout.php" class="btn btn-outline-danger ms-2">
                <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
            </a>
        </div>
    </nav> -->

    <div class="container">
        <h1>Perfil del Empleado</h1>
        <form name="frmEditar" id="frmEditar" method="POST" action="../../controlador/RH/EPerfil.php?idEmp=<?= $idEmp ?>">

            <fieldset>
                <legend>Datos Personales</legend>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $datos->nombre ?>" readonly>
                </div>

                <div class="mb-3">
                    <label for="apellidoP" class="form-label">Apellido Paterno:</label>
                    <input type="text" class="form-control" id="apellidoP" name="apellidoP" value="<?= $datos->apellidoP ?>" readonly>
                </div>

                <div class="mb-3">
                    <label for="apellidoM" class="form-label">Apellido Materno:</label>
                    <input type="text" class="form-control" id="apellidoM" name="apellidoM" value="<?= $datos->apellidoM ?>" readonly>
                </div>

            <fieldset>
                <legend>Credenciales de Usuario</legend>

                <div class="mb-3">
                    <label for="contrasena">Usuario:</label>
                    <input class="form-control" type="text" id="user" name="user"  value="<?= $datos->usuarios ?>" readonly >
                </div>

                <div class="mb-3">
                    <label for="confirmarContrasena">Contraseña:</label>
                    <input class="form-control" type="password" id="confirmarContrasena" name="confirmarContrasena" value="<?= $datos->contrasena ?>" required readonly>
                    
                    <span class="form-check-input" type="radio" style="cursor: pointer;" onclick="togglePassword()">
                        <i id="toggleIcon" class="fas fa-eye"></i>
                    </span>
                    <label class="form-check-label" for="flexRadioDisabled">
                        Mostrar Contraseña
                    </label>
                </div>

            </fieldset>
                         

            <div class="d-grid gap-2 col-6 mx-auto">
                <button type="button" class="btn btn-secondary" id="btnEditar"><i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i> Editar</button>
                <button class="btn btn-primary" id="btnGuardar" type="submit"><i class="fa-solid fa-floppy-disk" style="color: #ffffff;"></i> Guardar Cambios</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../../controlador/RH/togglePassword.js"></script>
    <script src="../../controlador/RH/buttonP.js"></script>
    
</body>
</html>