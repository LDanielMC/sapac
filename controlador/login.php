<?php
session_start();
include('../modelo/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    $query = "SELECT contrato.idCont, contrato.departamento, contrato.idEmp, contrato.puesto
              FROM perfiles 
              INNER JOIN contrato ON perfiles.idCont = contrato.idCont 
              WHERE perfiles.usuarios = ? AND perfiles.contrasena = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $usuario, $contrasena);
    $stmt->execute();
    $result = $stmt->get_result();
    $datos = $result->fetch_assoc();

    if ($datos) {   
        //Guardar el usuario y el id del contrato en la sesion  
        $_SESSION['usuario'] = $usuario;
        $_SESSION['departamento'] = $datos['departamento'];
        $_SESSION['puesto'] = $datos['puesto'];
        $_SESSION['idCont'] = $datos['idCont']; // Almacenar solo 'idCont'
        $_SESSION['idEmp'] = $datos['idEmp']; // Almacenar solo 'idEmp'

        if($datos['puesto']==='Comisario'){
            header("Location: ../vista/CA/homeCA.php");
        }else{
            switch ($datos['departamento']) {
                case 'Recursos Humanos':
                    header("Location: ../vista/RH/homeRH.php");
                    break;
                default:
                    header("Location: ../vista/SP/homeSP.php");
                    break;
            }
        }



        exit();
    } else {
        echo "<script>alert('¡Contraseña incorrecta!'); window.location.href='../index.php';</script>";
    }
}
?>



