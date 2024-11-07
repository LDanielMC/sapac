<?php  include '../../modelo/db.php'?>
<?php  //include 'includes/header.php'?>

<?php
    $hoy = date("Y-m-d");
    $nom1=isset($_POST['nombre']) ? $_POST['nombre']: null; //es el nombre de la persona cuando no es anonima
    $tel= isset($_POST['telefono']) ? $_POST['telefono']: null ; //telefono de la persona cuando no es anonima
    $domi= $_POST['domicilio']; 
    $cu= isset($_POST['cuenta']) ? $_POST['cuenta'] : null;
    $mtv=$_POST['motivo'];
    $responsable=$_POST['nrp'];
    $hs=$_POST['hechos'];
    $especificacion = isset($_POST['espe']) ? $_POST['espe'] : null;

    if (!empty($especificacion)) {
        $prueba = "Sí";
    } else {
        $prueba = "No";
    }
    

    $sql = "insert into buzon
    (feBu,nombreCompleto, telefono, domicilio, cuenta,motivo,nomCompResp,hechos,pruebas,especificacion) 
    values ('$hoy',$nom1,$tel,$domi,$cu,$mtv,$responsable,$hs,$prueba,$especificacion);";
    $execute = mysqli_query($conn,$sql);
    sleep(3);
    header("Location: quejas.html");
?>
<!-- <p><a href="admin.php"><img src="./Static/img/back.png"></p>           -->