<?php 

define("USER", "root");
define("SERVER", "localhost");
define("BD", "bdsapac");
define("PASS", "");
define("BACKUP_PATH", "../respaldo/");
date_default_timezone_set('America/Mexico_City');

class SGBD {

    // Método para ejecutar consultas SQL
    public static function sql($query) {

        $con = mysqli_connect(SERVER, USER, PASS, BD);

        if (!$con) {
            die("Error al conectar con el servidor: " . mysqli_connect_error());
        }

        mysqli_set_charset($con, 'utf8');

        // Ejecutar consulta
        $result = mysqli_query($con, $query);

        // Verificar errores en la consulta
        if (!$result) {
            echo "Error en la consulta SQL ejecutada: " . mysqli_error($con);
        }

        // Cerrar conexión
        mysqli_close($con);

        return $result;
    }

    // Método para limpiar cadenas y evitar inyecciones SQL
    public static function limpiarcadena($valor) {
        $valor = addslashes($valor);
        $valor = str_ireplace("<script>", "", $valor);
        $valor = str_ireplace("</script>", "", $valor);
        $valor = str_ireplace("SELECT * FROM", "", $valor);
        $valor = str_ireplace("DELETE FROM", "", $valor);
        $valor = str_ireplace("UPDATE", "", $valor);
        $valor = str_ireplace("INSERT INTO", "", $valor);
        $valor = str_ireplace("DROP TABLE", "", $valor);
        $valor = str_ireplace("TRUNCATE TABLE", "", $valor);
        $valor = str_ireplace("--", "", $valor);
        $valor = str_ireplace("'", "", $valor);
        $valor = str_ireplace("[", "", $valor);
        $valor = str_ireplace("]", "", $valor);
        $valor = str_ireplace("\\", "", $valor);
        $valor = str_ireplace("=", "", $valor);
        return $valor;
    }
}
?>
