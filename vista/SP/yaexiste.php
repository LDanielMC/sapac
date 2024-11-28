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
    <title>Error al Subir Documento</title>
    <link href="https://fonts.cdnfonts.com/css/biennale" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Animación del icono */
        .error-icon {
            font-size: 50px;
            color: #dc3545;
            animation: shake 1s ease;
        }

        /* Efecto shake */
        @keyframes shake {
            0% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            50% { transform: translateX(10px); }
            75% { transform: translateX(-10px); }
            100% { transform: translateX(0); }
        }

        /* Transición para la alerta */
        .alert-danger {
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
        .btn-danger {
            transition: background-color 0.3s, transform 0.3s;
        }
        .btn-danger:hover {
            background-color: #c82333;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<div class="container text-center mt-5">
    <div class="alert alert-danger" role="alert">
        <i class="fas fa-exclamation-circle error-icon"></i> <!-- Icono de error animado -->
        <h4 class="alert-heading mt-3">¡Error!</h4>
        <p>Ya existe un archivo previamente subido para este campo. </p>
        <hr>
        <p class="mb-0">Da click en el boton de abajo para volver.</p>
    </div>

    <a href="homeSP.php" class="btn btn-danger mt-3">Regresar</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
