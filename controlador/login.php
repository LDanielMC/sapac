<?php
session_start();
include('../modelo/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Consulta para validar el usuario y obtener datos de departamento y estatus
    $query = "SELECT contrato.departamento, contrato.estatus 
              FROM perfiles 
              INNER JOIN contrato ON perfiles.idCont = contrato.idCont 
              WHERE perfiles.usuarios = ? AND perfiles.contrasena = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $usuario, $contrasena);
    $stmt->execute();
    $result = $stmt->get_result();
    $datos = $result->fetch_assoc();

    if ($datos) {
        // Verificar si el usuario es de Recursos Humanos y está Activo
        if ($datos['departamento'] === 'Recursos Humanos' && $datos['estatus'] === 'Activo') {
            // Guardar el usuario en la sesión y redirigir a la página principal
            $_SESSION['usuario'] = $usuario;
            header("Location: ../vista/RH/homeRH.php");
            exit();
        } else {
            echo"No tienes permiso para acceder a estos archivos.";
        }
    } else {
        echo  "Credenciales incorrectas.";
    }
}
?>