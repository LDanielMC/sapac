<?php
include_once 'conect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['restoreFile']) && $_FILES['restoreFile']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['restoreFile']['tmp_name'];
        $fileName = $_FILES['restoreFile']['name'];
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        if ($fileExtension === 'sql') {
            $sqlContent = file_get_contents($fileTmpPath);

            if ($sqlContent !== false) {
                $sqlStatements = explode(';', $sqlContent);
                $sqlStatements = array_filter($sqlStatements, function ($line) {
                    $line = trim($line);
                    return !empty($line) && substr($line, 0, 2) !== '--' && substr($line, 0, 1) !== '#';
                });

                $sqlQueries = implode(';', $sqlStatements) . ';';

                $con = mysqli_connect(SERVER, USER, PASS, BD);

                if (!$con) {
                    die("Error al conectar con el servidor: " . mysqli_connect_error());
                }

                mysqli_set_charset($con, 'utf8');

                if (mysqli_multi_query($con, $sqlQueries)) {
                    while (mysqli_next_result($con)) {}

                    // Define los triggers aquí
                    $triggers = "
                        DROP TRIGGER IF EXISTS `InHisEmp`;
                        CREATE TRIGGER `InHisEmp` AFTER INSERT ON `empleado` FOR EACH ROW
                        BEGIN
                            INSERT INTO historial VALUES (0,
                            CONCAT_WS(' ', 'Registro de Empleado', NEW.nombre, NEW.apellidoP, NEW.telefono,
                            'Realizado por:', USER(), 'Fecha:', NOW()));
                        END;

                        DROP TRIGGER IF EXISTS `UpHisEmp`;
                        CREATE TRIGGER `UpHisEmp` AFTER UPDATE ON `empleado` FOR EACH ROW
                        BEGIN
                            INSERT INTO historial VALUES (0,
                            CONCAT_WS(' ', 'Actualización de Empleado', NEW.nombre, NEW.apellidoP, NEW.telefono,
                            'Realizado por:', USER(), 'Fecha:', NOW()));
                        END;

                        DROP TRIGGER IF EXISTS `GenerarUsuario`;
                        CREATE TRIGGER `GenerarUsuario` AFTER INSERT ON `contrato` FOR EACH ROW
                        BEGIN
                            DECLARE nom VARCHAR(2);
                            DECLARE ape VARCHAR(4);
                            DECLARE anioinicio VARCHAR(4);
                            DECLARE usuariofinal VARCHAR(20);

                            SELECT UPPER(SUBSTRING(e.nombre, 1, 2)) INTO nom
                            FROM empleado e
                            WHERE e.idemp = NEW.idemp;

                            SELECT UPPER(SUBSTRING(e.apellidop, 1, 4)) INTO ape
                            FROM empleado e
                            WHERE e.idemp = NEW.idemp;

                            SET anioinicio = YEAR(NEW.fein);
                            SET usuariofinal = CONCAT(nom, ape, anioinicio, NEW.idcont);

                            INSERT INTO perfiles (usuarios, idcont)
                            VALUES (usuariofinal, NEW.idcont);
                        END;

                        DROP TRIGGER IF EXISTS `prueba`;
                        CREATE TRIGGER `prueba` AFTER INSERT ON `contrato` FOR EACH ROW
                        BEGIN
                            INSERT INTO dpinicial (estado, idEmp) VALUES ('Sin entregar', NEW.idEmp);
                            INSERT INTO recepcion (estado, idEmp) VALUES ('Sin entregar', NEW.idEmp);
                        END;

                        DROP TRIGGER IF EXISTS `InHisCont`;
                        CREATE TRIGGER `InHisCont` AFTER INSERT ON `contrato` FOR EACH ROW
                        BEGIN
                            INSERT INTO historial VALUES (0,
                            CONCAT_WS(' ', 'Registro de Contrato', NEW.departamento, NEW.puesto, NEW.feIn, NEW.estatus,
                            'Realizado por:', USER(), 'Fecha:', NOW()));
                        END;

                        DROP TRIGGER IF EXISTS `actualizarfechatermino`;
                        CREATE TRIGGER `actualizarfechatermino` BEFORE UPDATE ON `contrato` FOR EACH ROW
                        BEGIN
                            IF NEW.estatus = 'Inactivo' THEN
                                SET NEW.feTer = CURDATE();
                            END IF;
                        END;

                        DROP TRIGGER IF EXISTS `prueba2`;
                        CREATE TRIGGER `prueba2` AFTER UPDATE ON `contrato` FOR EACH ROW
                        BEGIN
                            IF NEW.estatus = 'Inactivo' AND NEW.feTer IS NOT NULL THEN
                                INSERT INTO dpconclusion (estado, idEmp) VALUES ('Sin entregar', NEW.idEmp);
                                INSERT INTO entrega (estado, idEmp) VALUES ('Sin entregar', NEW.idEmp);
                            END IF;
                        END;

                        DROP TRIGGER IF EXISTS `UpHisCont`;
                        CREATE TRIGGER `UpHisCont` AFTER UPDATE ON `contrato` FOR EACH ROW
                        BEGIN
                            INSERT INTO historial VALUES (0,
                            CONCAT_WS(' ', 'Actualización de Contrato', NEW.departamento, NEW.puesto, 
                            NEW.feIn, NEW.feTer, NEW.estatus,
                            'Realizado por:', USER(), 'Fecha:', NOW()));
                        END;

                        DROP TRIGGER IF EXISTS `InHisPer`;
                        CREATE TRIGGER `InHisPer` AFTER INSERT ON `perfiles` FOR EACH ROW
                        BEGIN
                            INSERT INTO historial VALUES (0,
                            CONCAT_WS(' ', 'Registro de perfiles', NEW.usuarios,
                            'Realizado por:', USER(), 'Fecha:', NOW()));
                        END;

                        DROP TRIGGER IF EXISTS `UpHisPer`;
                        CREATE TRIGGER `UpHisPer` AFTER UPDATE ON `perfiles` FOR EACH ROW
                        BEGIN
                            INSERT INTO historial VALUES (0,
                            CONCAT_WS(' ', 'Actualización de Perfil', NEW.usuarios,
                            'Realizado por:', USER(), 'Fecha:', NOW()));
                        END;

                        DROP TRIGGER IF EXISTS `InHisInv`;
                        CREATE TRIGGER `InHisInv` AFTER INSERT ON `investigacion` FOR EACH ROW
                        BEGIN
                            INSERT INTO historial VALUES (0,
                            CONCAT_WS(' ', 'Registro de Investigaciones', NEW.titulo, NEW.feInicio, NEW.responsable,
                            NEW.estatus, NEW.retroalimentacion,
                            'Realizado por:', USER(), 'Fecha:', NOW()));
                        END;

                        DROP TRIGGER IF EXISTS `UpHisInv`;
                        CREATE TRIGGER `UpHisInv` AFTER UPDATE ON `investigacion` FOR EACH ROW
                        BEGIN
                            INSERT INTO historial VALUES (0,
                            CONCAT_WS(' ', 'Actualizaciones de Investigaciones', NEW.titulo, 
                            NEW.feInicio, NEW.feTermino, NEW.responsable,
                            NEW.estatus, NEW.retroalimentacion,
                            'Realizado por:', USER(), 'Fecha:', NOW()));
                        END;
                    ";

                    if (mysqli_multi_query($con, $triggers)) {
                        echo "<script>
                                alert('Base de datos restaurada y triggers creados exitosamente.');
                                setTimeout(function() {
                                    window.location.href = '../vista/CA/homeCA.php';
                                }, 2000);
                              </script>";
                    } else {
                        echo "Error al crear los triggers: " . mysqli_error($con);
                    }
                } else {
                    echo "Error al ejecutar las consultas: " . mysqli_error($con);
                }

                mysqli_close($con);
            } else {
                echo "Error al leer el contenido del archivo.";
            }
        } else {
            echo "Por favor, suba un archivo con extensión .sql.";
        }
    } else {
        echo "No se cargó ningún archivo.";
    }
} else {
    echo "Método no permitido.";
}
?>
