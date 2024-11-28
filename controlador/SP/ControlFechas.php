<?php
include '../../modelo/db.php';

// session_start();
$idCont = $_SESSION['idCont'];

// Ejecutar funciones SQL
$sqlInicio = "SELECT rangoDPinicio($idCont) AS enRangoInicio";
$resultInicio = $conn->query($sqlInicio);
$enRangoInicio = $resultInicio->fetch_assoc()['enRangoInicio'];
// echo $enRangoInicio;

$sqlTermino = "SELECT rangoDPtermino($idCont) AS enRangoTermino";
$resultTermino = $conn->query($sqlTermino);
$enRangoTermino = $resultTermino->fetch_assoc()['enRangoTermino'];
// echo $enRangoTermino;

$sqlMayo = "SELECT es_mayo() AS esMayo";
$resultMayo = $conn->query($sqlMayo);
$esMayo = $resultMayo->fetch_assoc()['esMayo'];
// echo $esMayo;

$sqlEntrega = "SELECT rangoEntrega($idCont) AS RangoEntrega";
$resultEntrega = $conn->query($sqlEntrega);
$enRangoEntrega = $resultEntrega->fetch_assoc()['RangoEntrega'];
// echo $enRangoEntrega;

$sqlRecepcion = "SELECT rangoRecepcion($idCont) AS RangoRecepcion";
$resultRecepcion = $conn->query($sqlRecepcion);
$enRangoRecepcion = $resultRecepcion->fetch_assoc()['RangoRecepcion'];
// echo $enRangoRecepcion;

$conn->close();

// Pasar datos a JavaScript
echo "<script>
    const enRangoInicio = " . json_encode($enRangoInicio) . ";
    const enRangoTermino = " . json_encode($enRangoTermino) . ";
    const esMayo = " . json_encode($esMayo) . ";
    const enRangoEntrega = " . json_encode($enRangoEntrega) . ";
    const enRangoRecepcion = " . json_encode($enRangoRecepcion) . ";
</script>";

echo "<script src='habilitarCampos.js'></script>";
?>
