<?php
include('../../modelo/db.php');
include('../../controlador/CA/sendObservacion.php');

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
<?php


if (isset($_GET['id'])) {
    $idDPC = $_GET['id'];
    // Consulta para obtener detalles del documento y empleado
    $query = $conn->query("SELECT e.nombre, e.apellidoP,e.apellidoM, e.correo, e.telefono, c.feIn,c.departamento, d.acuse, d.idEmp
                           FROM empleado e
                           JOIN dpconclusion d ON e.idEmp = d.idEmp 
                           JOIN contrato c ON e.idEmp = c.idEmp
                           WHERE d.id_DPC = $idDPC;");
    $data = $query->fetch_object();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $estado = $_POST['estado'];
    $observaciones = $_POST['observaciones'] ?? '';
    $correoEmpleado = $data->correo;

    if ($estado === 'Rechazado' && !empty($observaciones)) {

        $mensajeHTML = nl2br(htmlspecialchars($observaciones, ENT_QUOTES, 'UTF-8'));

        // Enviar correo con PHPMailer
        enviarCorreo($correoEmpleado, "Documento Rechazado: Declaracion de Conclusion", $mensajeHTML);

        // Actualizar el estado del registro actual a "Rechazado"
        $conn->query("UPDATE dpconclusion 
                      SET estado = 'Rechazado' 
                      WHERE id_DPC = $idDPC;");

        // Insertar un nuevo registro con estado "Sin entregar"
        $conn->query("INSERT INTO dpconclusion (idEmp, estado) 
                      VALUES ({$data->idEmp}, 'Sin entregar');");
        
    } elseif ($estado === 'Aceptado') {
        $conn->query("UPDATE dpconclusion SET estado = 'Aceptado' WHERE id_DPC = $idDPC;");
    }
    header('Location: conclusion.php');
}
?>
<?php include '../headers/headerCA.php'; ?> <br>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles Declaración Patrimonial</title>
    <link rel="stylesheet" href="../css/stylesSP.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <h1>Detalles del Documento</h1>
        <p><strong>Propietario:</strong> <?= $data->nombre . ' ' . $data->apellidoP . ' ' . $data->apellidoM ?></p>
        <p><strong>Correo:</strong> <?= $data->correo ?></p>
        <p><strong>Teléfono:</strong> <?= $data->telefono ?></p>
        <p><strong>Departamento:</strong> <?= $data->departamento ?></p>
        <p><strong>Inicio del Contrato:</strong> <?= $data->feIn ?></p>
        <p><strong>Documento:</strong>  <a href="<?= $data->acuse ?>" target="_blank" class="document-link">
                                            <i class="fas fa-file-alt"></i> Ver documento
                                        </a></p>

        <form method="POST">
            <div class="mb-3">
                <label for="estado" class="form-label">Cambiar Estado</label>
                <select id="estado" name="estado" class="form-select" required>
                    <option value="">Seleccione</option>
                    <option value="Aceptado">Aceptar</option>
                    <option value="Rechazado">Rechazar</option>
                </select>
            </div>
            <div class="mb-3" id="observacionesContainer" style="display: none;">
                <label for="observaciones" class="form-label">Observaciones</label>
                <textarea id="observaciones" name="observaciones" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Confirmar</button>
        </form>
    </div>

    <script>
        const estadoSelect = document.getElementById('estado');
        const observacionesContainer = document.getElementById('observacionesContainer');

        estadoSelect.addEventListener('change', () => {
            observacionesContainer.style.display = estadoSelect.value === 'Rechazado' ? 'block' : 'none';
        });
    </script>
</body>
</html>