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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pruebas</title>
    <link rel="stylesheet" href="../css/styleVerArchivos.css">
</head>
<body>
    <div class="container">
        <h1>Pruebas del Buzón de Quejas</h1>
        <?php
        include '../../modelo/db.php';

        // Verificar conexión
        if (!$conn) {
            die("Error de conexión: " . mysqli_connect_error());
        }

        // Obtener y sanitizar el ID recibido
        $idPrueba = isset($_GET['idB']) ? (int) filter_var($_GET['idB'], FILTER_SANITIZE_NUMBER_INT) : 0;

        // Validar que el ID sea válido
        if ($idPrueba > 0) {
            // Consulta para obtener la especificación
            $sqlQuery = "SELECT especificacion FROM buzon WHERE idB = ?";
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bind_param("i", $idPrueba);
            $stmt->execute();
            $result = $stmt->get_result();

            // Verificar si hay resultados
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                // Obtener la cadena con los nombres de los archivos
                $archivos = $row['especificacion'];

                // Verificar si el campo especificación está vacío o es null
                if (empty($archivos)) {
                    echo "<p class='no-files'>No hay pruebas existentes.</p>";
                } else {
                    // Separar los nombres de los archivos por comas
                    $listaArchivos = explode(',', $archivos);
                    
                    echo "<div class='file-list'>";
                    // Mostrar cada archivo
                    foreach ($listaArchivos as $archivo) {
                        $archivo = trim($archivo);
                        if (!empty($archivo)) {
                            $rutaArchivo = "../../uploads/EvidenciasQuejas/" . $archivo;

                            // Comprobar si el archivo es una imagen para mostrarla
                            $ext = pathinfo($archivo, PATHINFO_EXTENSION);
                            echo "<div class='file-item'>";
                            if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif'])) {
                                echo "<img src='$rutaArchivo' alt='Evidencia'>";
                            } else {
                                // Si no es una imagen, mostrar un enlace de descarga
                                echo "<p>Archivo: $archivo</p>";
                            }
                            echo "<a href='$rutaArchivo' download='$archivo'>Descargar $archivo</a>";
                            echo "</div>";
                        }
                    }
                    echo "</div>";
                }
            } else {
                echo "<p class='no-files'>No se encontraron pruebas para este ID.</p>";
            }

            // Cerrar conexión
            $stmt->close();
        } else {
            echo "<p class='no-files'>ID no válido.</p>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
