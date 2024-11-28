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
<?php

include '../headers/headerCA.php';
include '../../modelo/db.php';

// Consulta para obtener usuarios con registros aceptados en ambas tablas
$query = "
SELECT e.idEmp, e.nombre, e.apellidoP, e.correo 
FROM empleado e
JOIN dpconclusion dpc ON e.idEmp = dpc.idEmp AND dpc.estado = 'Aceptado'
JOIN entrega ent ON e.idEmp = ent.idEmp AND ent.estado = 'Aceptado'
JOIN contrato c ON e.idEmp = c.idEmp
JOIN perfiles p ON c.idCont = p.idCont
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Usuarios</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
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
        <h1 class="text-center">Eliminar Usuarios</h1>
        <br>
        <?php if ($result->num_rows > 0): ?>
            <form action="../../controlador/CA/procesarEliminacion.php" method="POST">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Email</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['idEmp']; ?></td>
                                <td><?php echo $row['nombre']; ?></td>
                                <td><?php echo $row['apellidoP']; ?></td>
                                <td><?php echo $row['correo']; ?></td>
                                <td>
                                    <input type="checkbox" name="usuarios[]" value="<?php echo $row['idEmp']; ?>">
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-danger">Eliminar Seleccionados</button>
            </form>
        <?php else: ?>
            <p class="text-center">No hay usuarios disponibles para eliminar.</p>
        <?php endif; ?>
    </div>
</body>
</html>
