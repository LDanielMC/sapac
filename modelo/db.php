<?php  
$conn = mysqli_connect("localhost","root","","bdsapac");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}else{
    echo 'conexion exitosa';
}
?>