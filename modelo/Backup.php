<?php
include 'conect.php';

// Obtener fecha y hora para el nombre del archivo de respaldo
$day = date("d");
$mont = date("m");
$year = date("Y");
$hora = date("H-i-s");
$fecha = $day . '_' . $mont . '_' . $year;
$DataBASE = $fecha . "_(" . $hora . "_hrs).sql";

// Definir el orden de las tablas
$orderedTables = [
    'empleado',        // Tabla principal
    'contrato',        // Depende de empleado
    'perfiles',        // Depende de empleado
    'dpinicial',       // Depende de contrato
    'dpconclusion',    // Depende de contrato
    'dpmayo',          // Depende de contrato
    'recepcion',       // Depende de contrato
    'entrega',         // Depende de contrato
    'buzon',           // Depende de empleado
    'investigacion',   // Depende de empleado
    'historial'        // Tabla histórica
];

// Crear el script SQL
$sql = ''; 
$sql .= 'USE `' . BD . "`;\n\n";

// Respaldo de las tablas en el orden deseado
foreach ($orderedTables as $table) {
    // Respaldo de estructura de la tabla
    $sql .= 'DROP TABLE IF EXISTS `' . $table . '`;' . "\n";
    
    $resultStructure = SGBD::sql('SHOW CREATE TABLE `' . $table . '`');
    if (!$resultStructure || mysqli_num_rows($resultStructure) == 0) {
        continue; // Saltar si no se puede obtener la estructura
    }
    
    $row2 = mysqli_fetch_row($resultStructure);
    $createTableSQL = $row2[1];

    // Cambiar el motor a InnoDB
    $createTableSQL = preg_replace('/ENGINE=\w+/', 'ENGINE=InnoDB', $createTableSQL);

    $sql .= $createTableSQL . ";\n\n";

    // Respaldo de datos de la tabla
    $resultData = SGBD::sql('SELECT * FROM `' . $table . '`');
    if ($resultData) {
        $numFields = mysqli_num_fields($resultData);
        while ($row = mysqli_fetch_row($resultData)) {
            $sql .= 'INSERT INTO `' . $table . '` VALUES(';
            for ($j = 0; $j < $numFields; $j++) {
                if (is_null($row[$j])) {
                    $sql .= 'NULL'; // Manejo de valores nulos
                } elseif (is_numeric($row[$j]) && !is_string($row[$j])) {
                    $sql .= $row[$j]; // Manejo de valores numéricos
                } else {
                    $sql .= '"' . addslashes($row[$j]) . '"'; // Manejo de cadenas
                }
                if ($j < ($numFields - 1)) {
                    $sql .= ', ';
                }
            }
            $sql .= ");\n";
        }
    }
    $sql .= "\n\n";
}

// Configurar encabezados para la descarga
header('Content-Type: application/sql');
header('Content-Disposition: attachment; filename="' . $DataBASE . '"');
header('Content-Length: ' . strlen($sql));

// Enviar el contenido al navegador
echo $sql;
exit;
?>
