<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Archivos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Cargar Archivos</h1>
        
        <div class="mb-3">
            <label for="declaracion" class="form-label">Declaraciones Patrimoniales</label>
            <input type="file" id="declaracion" class="form-control" accept=".pdf" disabled>
        </div>
        
        <div class="mb-3">
            <label for="entrega" class="form-label">Entrega</label>
            <input type="file" id="entrega" class="form-control" accept=".pdf" disabled>
        </div>
        
        <div class="mb-3">
            <label for="recepcion" class="form-label">Recepción</label>
            <input type="file" id="recepcion" class="form-control" accept=".pdf" disabled>
        </div>
    </div>

    <!-- Enlace al archivo JavaScript -->
    <script src="../../controlador/SP/habilitarCampos.js"></script>
</body>
</html>

