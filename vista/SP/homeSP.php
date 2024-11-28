<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
    exit();
}
?>
<?php include '../headers/headerSP.php'; ?><br>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Archivos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<?php include '../../controlador/SP/ControlFechas.php'; ?>

<nav class="navbar navbar-light bg-light px-3">
    <div class="container-fluid">
        <span class="navbar-text ms-auto" style="font-size: 20px;">
            <i class="bi bi-person-circle"></i> <?php echo $_SESSION['usuario']; ?>
        </span>
        <a href="../../controlador/logout.php" class="btn btn-outline-danger ms-2">
            <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
        </a>
    </div>
</nav>

<div class="container mt-5">
    <h1 class="text-center mb-4"><i class="bi bi-file-earmark-arrow-up-fill text-primary"></i> Cargar Archivos</h1>
    
    <!-- Sección Declaraciones Patrimoniales -->
    <section class="mb-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h2><i class="bi bi-file-earmark-text"></i> Declaraciones Patrimoniales</h2>
            </div>
            <div class="card-body">
                <form action="../../controlador/SP/subirArchivos.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-upload"></i> Declaración Patrimonial de Inicio</label>
                        <input type="file" id="dpinicial" name="dpinicial" class="form-control" accept=".pdf" disabled>
                        <button type="submit" name="submit_dpi" id="submit_dpi" class="btn btn-primary mt-2" disabled>Subir</button>
                    </div><br>
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-pencil-square"></i> Declaración Patrimonial de Modificación</label>
                        <input type="file" id="dpmodificacion" name="dpmodificacion" class="form-control" accept=".pdf" disabled>
                        <p class="text-warning mt-2"><small>Recuerda que si iniciaste contrato en mayo, el sistema verificará si ya existe un archivo.</small></p>
                        <button type="submit" name="submit_dpm" id="submit_dpm" class="btn btn-primary mt-2" disabled>Subir</button>
                        
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-file-earmark-check"></i> Declaración Patrimonial de Conclusión</label>
                        <input type="file" id="dptermino" name="dptermino" class="form-control" accept=".pdf" disabled>
                        <button type="submit" name="submit_dpc" id="submit_dpc" class="btn btn-primary mt-2" disabled>Subir</button>
                    </div>
                    <a href="declaraciones.php" class="btn btn-link float-end"><i class="bi bi-clock-history"></i> Ver historial</a>
                </form>
            </div>
        </div>
    </section>

    <!-- Sección Recepción -->
    <section>
        <div class="card shadow">
            <div class="card-header bg-warning text-white">
                <h2><i class="bi bi-box-arrow-in-down"></i> Recepción</h2>
            </div>
            <div class="card-body">
                <form action="../../controlador/SP/subirArchivos.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-upload"></i> Subir Recepción</label>
                        <input type="file" id="recepcion" name="recepcion" class="form-control" accept=".pdf" disabled>
                        <button type="submit" name="submit_recepcion" id="submit_recepcion" class="btn btn-warning mt-2" disabled>Subir</button>
                    </div>
                    <a href="recepcion.php" class="btn btn-link float-end"><i class="bi bi-clock-history"></i> Ver Recepción</a>
                </form>
            </div>
        </div>
    </section><br><br>

    <!-- Sección Entrega -->
    <section class="mb-5">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h2><i class="bi bi-box-seam"></i> Entrega</h2>
            </div>
            <div class="card-body">
                <form action="../../controlador/SP/subirArchivos.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-upload"></i> Subir Entrega</label>
                        <input type="file" id="entrega" name="entrega" class="form-control" accept=".pdf" disabled>
                        <button type="submit" name="submit_entrega" id="submit_entrega" class="btn btn-success mt-2" disabled>Subir</button>
                    </div>
                    <a href="entrega.php" class="btn btn-link float-end"><i class="bi bi-clock-history"></i> Ver Entrega</a>
                </form>
            </div>
        </div>
    </section>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-5">
    <div class="container">
        <p class="mb-1">&copy; 2024 Sistema de Gestión S A P A C </p>
        <p class="mb-0">
            <a href="mailto:sapac.avisos@gmail.com" class="text-white text-decoration-none"><i class="bi bi-envelope"></i> Contacto</a> |
            <a href="#" class="text-white text-decoration-none"><i class="bi bi-house""></i> Subir </a>
        </p>
    </div>
</footer>

<!-- Enlace al archivo JavaScript -->
<script src="../../controlador/SP/habilitarCampos.js"></script>
</body>
</html>
