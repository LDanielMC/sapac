# SAPAC

Sistema web para controlar que los servidores públicos del Sistema de Agua Potable y Alcantarillado del Municipio de Cuernavaca entreguen a tiempo sus declaraciones patrimoniales (inicial, anual y de conclusión) y los documentos de entrega-recepción. Lo usan la Comisaría (que da seguimiento), Recursos Humanos y los propios servidores públicos.

## Funcionalidades principales

- **Tres perfiles con su propio panel:** Comisaría (el puesto "Comisario"), Recursos Humanos y servidores públicos. El panel se elige al iniciar sesión según el puesto y el departamento del contrato.
- **Recursos Humanos:** alta de empleados y edición de sus datos personales, contrato y perfil, con cambio de estatus. Al registrar un contrato, un disparador de la base de datos genera el usuario de acceso.
- **Declaraciones patrimoniales:** el servidor público sube sus archivos de declaración inicial, anual (mayo) y de conclusión, dentro de los plazos que calcula la base de datos (la inicial, 60 días hábiles desde el inicio del contrato). Cada año, un evento programado genera el registro pendiente de la declaración de mayo.
- **Entrega-recepción:** carga y consulta de los documentos de entrega y de recepción.
- **Seguimiento de la Comisaría:** consulta de entregas y recepciones por estado, detalle de cada declaración, visualización de los archivos subidos y bitácora de cambios.
- **Recordatorios por correo** a quienes tienen pendientes, y envío de observaciones a los servidores públicos (PHPMailer).
- **Buzón de quejas:** formulario para presentar quejas, que la Comisaría convierte en investigaciones con responsable, fechas, estatus y retroalimentación.
- **Reportes en PDF** (FPDF) generados desde la sección de la Comisaría.
- **Contraseñas con hash:** se guardan con `password_hash` (bcrypt) al crear o cambiar el perfil y se validan con `password_verify` al iniciar sesión; el historial de cambios no las registra.
- **Respaldo y restauración** de la base de datos desde la aplicación.
- **Historial de cambios:** disparadores que registran altas y modificaciones de empleados, contratos, perfiles e investigaciones.

## Capturas

<!-- Agrega aquí tus imágenes, por ejemplo: ![Inicio de sesión](capturas/login.png) -->

_Pendiente._

## Stack

| Capa | Tecnología |
|---|---|
| Backend | PHP 8.3 (sin framework), `mysqli` con consultas preparadas; contraseñas con `password_hash` / `password_verify` |
| Base de datos | MySQL, con disparadores, funciones, procedimientos y eventos programados |
| Frontend | HTML, CSS y JavaScript, Bootstrap 5.3.3 y Bootstrap Icons 1.11.3 (por CDN) |
| Librerías incluidas | PHPMailer 6.9.2, FPDF 1.82 |

## Arquitectura

Aplicación en PHP con estructura Modelo-Vista-Controlador hecha a mano:

```
├── index.php         inicio de sesión
├── modelo/           conexión a la base (db.php, conect.php), respaldo y restauración, migración de contraseñas, plantilla de configuración de correo
├── controlador/
│   ├── login.php     autentica y redirige según puesto y departamento
│   ├── CA/           Comisaría: investigaciones, recordatorios, observaciones, reportes PDF
│   ├── RH/           Recursos Humanos: empleados, contratos y perfiles
│   ├── SP/           servidor público: subida de archivos y control de fechas
│   └── buzon/        alta de quejas
├── vista/            pantallas por perfil (CA, RH, SP, buzón) y hojas de estilo
├── librerias/        PHPMailer
└── bd.sql            esquema, disparadores, funciones, eventos y datos de ejemplo
```

La lógica de plazos y automatización vive en la base de datos (`bd.sql`): el disparador `GenerarUsuario`, funciones que calculan los plazos de las declaraciones y los eventos `insertar_dpmayo` y `eliminar_sin_entregar`, que corren cada año.

## Instalación y ejecución

Requisitos: PHP 8.3 y MySQL, por ejemplo con WAMP/XAMPP.

1. Copia el proyecto a la carpeta pública del servidor (por ejemplo `www/sapac` en WAMP).
2. Importa `bd.sql` en MySQL. **Atención:** el script empieza con `drop database if exists bdsapac`, así que reemplaza una base existente con ese nombre.
3. Activa el programador de eventos de MySQL para que corran los eventos anuales: `SET GLOBAL event_scheduler = ON;`
4. La conexión por defecto es `localhost`, usuario `root` sin contraseña y base `bdsapac`; si usas otros datos, edítalos en `modelo/db.php` y `modelo/conect.php`.
5. Para enviar correos, copia `modelo/mail_config.example.php` a `modelo/mail_config.php` y escribe el correo y la contraseña de aplicación de la cuenta que enviará los avisos. Ese archivo está en `.gitignore`.
6. Crea la carpeta `uploads/` en la raíz con permisos de escritura (ahí se guardan los archivos de declaraciones) y revisa la ruta de respaldos (`BACKUP_PATH` en `modelo/conect.php`).
7. Si ya tenías una base creada con una versión anterior, con contraseñas en texto plano, ejecuta una sola vez `php modelo/migrar_contrasenas.php`: convierte cada contraseña a hash, ensancha la columna `perfiles.contrasena` y oculta las contraseñas que el historial hubiera guardado. Es seguro repetirlo. Con una base nueva creada desde `bd.sql` no hace falta.
8. Abre `http://localhost/sapac/` e inicia sesión con un usuario de `perfiles`.

## Pruebas

El proyecto no incluye pruebas automatizadas.
