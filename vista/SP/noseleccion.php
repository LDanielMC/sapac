<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advertencia: No se ha Seleccionado un Archivo</title>
    <link href="https://fonts.cdnfonts.com/css/biennale" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Animación del icono */
        .warning-icon {
            font-size: 50px;
            color: #ffc107;
            animation: pulse 1.5s infinite;
        }

        /* Efecto pulse */
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.2);
            }
            100% {
                transform: scale(1);
            }
        }

        /* Transición para la alerta */
        .alert-warning {
            opacity: 0;
            animation: fadeIn 1.5s ease forwards;
        }

        /* Efecto fadeIn */
        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        /* Efecto para el botón */
        .btn-warning {
            transition: background-color 0.3s, transform 0.3s;
        }
        .btn-warning:hover {
            background-color: #e0a800;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<div class="container text-center mt-5">
    <div class="alert alert-warning" role="alert">
        <i class="fas fa-exclamation-triangle warning-icon"></i> <!-- Icono de advertencia animado -->
        <h4 class="alert-heading mt-3">¡Advertencia!</h4>
        <p>No se ha seleccionado un archivo. Por favor, selecciona un archivo antes de enviar.</p>
        <hr>
        <p class="mb-0">Da click en el boton de abajo para regresar y seleccionar un archivo.</p>
    </div>

    <a href="homeSP.php" class="btn btn-warning mt-3">Regresar</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
