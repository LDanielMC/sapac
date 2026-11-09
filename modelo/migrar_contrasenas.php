<?php
// Migra a hash las contraseñas que estén en texto plano en la tabla perfiles.
//
// Uso (una sola vez, desde la raíz del proyecto):
//     php modelo/migrar_contrasenas.php
//
// Es seguro volver a ejecutarlo: las contraseñas que ya son hash se omiten.
// Hace cuatro cosas:
//   1. Ensancha perfiles.contrasena a VARCHAR(255), que es lo que necesita password_hash().
//   2. Recrea los disparadores InHisPer y UpHisPer para que dejen de copiar la contraseña a historial.
//   3. Convierte cada contraseña en texto plano con password_hash().
//   4. Oculta en historial las contraseñas que esos disparadores guardaron antes.

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit("Este script solo se ejecuta desde la línea de comandos.\n");
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
require __DIR__ . '/db.php';
$conn->set_charset('utf8');

// 1. Columna lo bastante ancha para el hash
$conn->query("ALTER TABLE perfiles MODIFY contrasena VARCHAR(255) NULL");

// 2. Disparadores del historial sin la contraseña
$conn->query("DROP TRIGGER IF EXISTS InHisPer");
$conn->query("CREATE TRIGGER InHisPer AFTER INSERT ON perfiles FOR EACH ROW
    INSERT INTO historial VALUES (0,
        CONCAT_WS(' ', 'Registro de perfiles', NEW.usuarios, 'Realizado por: ', USER(), 'Fecha; ', NOW()))");
$conn->query("DROP TRIGGER IF EXISTS UpHisPer");
$conn->query("CREATE TRIGGER UpHisPer AFTER UPDATE ON perfiles FOR EACH ROW
    INSERT INTO historial VALUES (0,
        CONCAT_WS(' ', 'Actualizacion de Perfil', NEW.usuarios, 'Realizado por: ', USER(), 'Fecha; ', NOW()))");

// 3. Contraseñas en texto plano -> hash, y 4. ocultarlas en historial
$perfiles = $conn->query("SELECT idP, usuarios, contrasena FROM perfiles WHERE contrasena IS NOT NULL AND contrasena <> ''");
$actualizar = $conn->prepare("UPDATE perfiles SET contrasena = ? WHERE idP = ?");
$ocultar = $conn->prepare("UPDATE historial SET texto = REPLACE(texto, CONCAT(?, ' ', ?), CONCAT(?, ' [contraseña oculta]'))");

$migradas = 0;
$yaHasheadas = 0;
foreach ($perfiles->fetch_all(MYSQLI_ASSOC) as $perfil) {
    if (password_get_info($perfil['contrasena'])['algo'] !== null) {
        $yaHasheadas++;
        continue;
    }

    $hash = password_hash($perfil['contrasena'], PASSWORD_DEFAULT);
    $actualizar->bind_param('si', $hash, $perfil['idP']);
    $actualizar->execute();

    $ocultar->bind_param('sss', $perfil['usuarios'], $perfil['contrasena'], $perfil['usuarios']);
    $ocultar->execute();
    $migradas++;
}

echo "Contraseñas migradas a hash: $migradas\n";
echo "Ya estaban en hash (omitidas): $yaHasheadas\n";
echo "Listo. Las contraseñas antiguas que aparezcan en historial por cambios anteriores deben revisarse a mano.\n";
