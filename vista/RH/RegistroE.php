<?php
// session_start();

// if (!isset($_SESSION['usuario'])) {
//     header("Location: ../../index.php");
//     exit();
// }
?>

 <?php include '../headers/headerRH.php';?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Empleados</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.cdnfonts.com/css/biennale" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
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
        <h1>Registro de Empleados</h1>
        <form name="frmempleado" id="frmempleado" method="POST" onsubmit="return validarContrasenas()" action="../../controlador/RH/REmpleado.php">

        <fieldset>

                <legend>Datos Personales</legend>
                <div class="mb-3">
                    <label for="nombre"  class="form-label">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="apellidoPaterno">Apellido Paterno:</label>
                    <input type="text" class="form-control" id="apellidoPaterno" name="apellidoPaterno" required>
                </div>
                <div class="mb-3">
                    <label for="apellidoMaterno">Apellido Materno:</label>
                    <input type="text" class="form-control" id="apellidoMaterno" name="apellidoMaterno" required>
                </div>
                <div class="mb-3">
                    <label for="fechaNacimiento">Fecha de Nacimiento:</label>
                    <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento" required>
                </div>
                <div class="mb-3">
                    <label for="sexo">Sexo:</label>
                    <select  class="form-select" id="sexo" name="sexo" style="width: 40%" required>
                        <option value="">Seleccione</option>
                        <option value="masculino">Masculino</option>
                        <option value="femenino">Femenino</option>
                        
                    </select>
                </div>
                <div class="mb-3">
                    <label for="estadoCivil">Estado Civil:</label>
                    <select class="form-select" id="estadoCivil" name="estadoCivil" style="width: 40%" required>
                    <option value="">Seleccione</option>
                        <option value="soltero">Soltero/a</option>
                        <option value="casado">Casado/a</option>
                        <option value="divorciado">Divorciado/a</option>
                        <option value="viudo">Viudo/a</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="telefono">Teléfono:</label>
                    <input class="form-control" type="tel" id="telefono" name="telefono" required>
                </div>
                <div class="mb-3">
                    <label for="correo">Correo Electrónico:</label>
                    <input class="form-control" type="email" id="correo" name="correo" required>
                </div>
                <div class="mb-3">
                    <label for="domicilio">Domicilio:</label>
                    <input class="form-control" type="text" id="domicilio" name="domicilio" required></input>
                </div>
            </fieldset>

            <fieldset>
                <legend>Datos de Contrato</legend>
                <div class="mb-3">
                    <label for="rfc">RFC:</label>
                    <input class="form-control" type="text" id="rfc" name="rfc" required>
                </div>
                <div class="mb-3">
                    <label for="departamento">Departamento:</label>
                    <input class="form-control" type="text" id="departamento" name="departamento" required>
                </div>
                <div class="mb-3">
                    <label for="puesto">Puesto:</label>
                    <input class="form-control" type="text" id="puesto" name="puesto" required>
                </div>
                <div class="mb-3">
                    <label for="sueldo">Sueldo:</label>
                    <input class="form-control" type="number" id="sueldo" name="sueldo" required>
                </div>
            </fieldset>

            <fieldset>
                <legend>Credenciales de Usuario</legend>
                <p class="text-primary">El nombre de usuario se genera automaticamente, sus credenciales serán enviadas por correo</p>
                <div class="mb-3">
                    <label for="contrasena">Contraseña:</label>
                    <input class="form-control" type="password" id="contrasena" name="contrasena" required>
                </div>
                <div class="mb-3">
                    <label for="confirmarContrasena">Confirmar Contraseña:</label>
                    <input class="form-control" type="password" id="confirmarContrasena" name="confirmarContrasena" required>
                </div>
            </fieldset>

            <div class="d-grid gap-2 col-6 mx-auto">
                <button  class="btn btn-primary" type="submit">Registrar Empleado</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../../controlador/RH/validarpass.js"></script>
</body>
</html>