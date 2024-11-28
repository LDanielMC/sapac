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
    <title>Documento Subido</title>
    <link href="https://fonts.cdnfonts.com/css/biennale" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Animación del icono */
        .checkmark-icon {
            font-size: 50px;
            color: #28a745;
            animation: bounce 1.2s ease;
        }

        /* Efecto bounce */
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-20px);
            }
            60% {
                transform: translateY(-10px);
            }
        }

        /* Transición para la alerta */
        .alert-success {
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
        .btn-primary {
            transition: background-color 0.3s, transform 0.3s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<div class="container text-center mt-5">
    <div class="alert alert-success" role="alert">
        <i class="fas fa-check-circle checkmark-icon"></i> <!-- Icono de check animado -->
        <h4 class="alert-heading mt-3">¡Éxito!</h4>
        <p>El documento ha sido subido correctamente.</p>
        <hr>
        <p class="mb-0">Da click en el boton de abajo para ir al Historial.</p>
    </div>

    <a href="entrega.php" class="btn btn-primary mt-3">Documentos</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
