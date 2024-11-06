<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow-lg" style="width: 100%; max-width: 400px;">
            <div class="text-center mb-4">
                <img src="vista/img/log.png" alt="Logo" class="img-fluid mb-3" style="max-width: 80px;">
                <p class="text-muted">SISTEMA DE AGUA POTABLE Y ALCANTARILLADO DEL MUNICIPIO DE CUERNAVACA</p>
                <hr>
                <h2 class="text-primary">Iniciar Sesión</h2>
                
            </div>
            <form method="POST" action="controlador/login.php">
                <div class="mb-3">
                    <label for="usuario" class="form-label">
                        <i class="bi bi-person-fill"></i> Usuario:
                    </label>
                    <input type="text" class="form-control" id="usuario" name="usuario" required>
                </div>
                <div class="mb-3">
                    <label for="contrasena" class="form-label">
                        <i class="bi bi-lock-fill"></i> Contraseña:
                    </label>
                    <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                    <i class="bi bi-box-arrow-in-right"></i>  Ingresar
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
</html>
