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
<?php include '../../modelo/db.php'; ?>
<?php include '../../vista/headers/headerCA.php'; ?><br>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Investigaciones</title>
    <link rel="stylesheet" href="../css/stylesbuzon.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
        <h1 class="text-center">Creación de una investigación</h1>
    </div> 
    <br>
    <main class="main">
        <div class="container">
            <form name="frm" id="frm" method="POST" action="../../controlador/CA/CrearInvestigacion.php" onsubmit="return validarFormulario(event)">
            
            <div class="mb-3">
                <label for="idB" class="form-label" >ID de la queja</label>
                <input type="text" name="idB" id="idB" class="form-control" value="<?= $_GET['idB'];?>"  readonly>
            </div>

                <!-- Título -->
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título de la investigación:</label>
                    <input type="text" name="titulo" id="titulo" class="form-control" required>
                </div>

                <!-- Estatus -->
                <div class="mb-3">
                    <label for="estatus" class="form-label">Estatus:</label>
                    <input type="text" name="estatus" id="estatus" class="form-control" value="En proceso" readonly>
                </div>

                <!-- Responsable -->
                <div class="mb-3">
                    <label for="responsable" class="form-label">Lista de posibles responsables</label>
                    <select class="form-select" name="responsable" id="responsable" required>
                        <option value="">Despliegue los investigadores</option>
                    </select>
                </div>

                

                <!-- Retroalimentación -->
                <label for="retroalimentacion" class="form-label">Retroalimentación:</label>
                <textarea name="retroalimentacion" id="retroalimentacion" class="form-control"></textarea>
                <br>
                <!-- Botón de Enviar -->
                <div>
                    <button type="submit" class="form_btn">Enviar Cambios</button>
                </div>
            </form>  
        </div>
    </main> 

    <!-- Script para cargar investigadores -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('../../controlador/CA/ObtenerInv.php')
                .then(response => response.json())
                .then(data => {
                    console.log('Datos recibidos:', data); // Verifica qué datos recibes
                    const selectResponsable = document.getElementById('responsable');
                    
                    data.forEach(investigador => {
                        const option = document.createElement('option');
                        // Establece el valor como el nombre completo
                        option.value = investigador.nombreCompleto;
                        option.textContent = investigador.nombreCompleto;
                        selectResponsable.appendChild(option);
                    });
                })
                .catch(error => console.error('Error al cargar investigadores:', error));
        });

    </script>
</body>
</html>
