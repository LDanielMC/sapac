drop database if exists  bdsapac;
CREATE database `bdsapac` ;
use bdsapac;

/*SELECT empleado.idEmp, nombre, apellidoP, apellidoM, sexo, telefono, departamento
FROM empleado INNER JOIN contrato ON empleado.idEmp = contrato.idEmp;
select * from empleado;
select * from contrato;
select * from perfiles;*/


CREATE TABLE `bdsapac`.`empleado` (
  `idEmp` INT NOT NULL auto_increment,
  `nombre` VARCHAR(45) NOT NULL,
  `apellidoP` VARCHAR(20) NOT NULL,
  `apellidoM` VARCHAR(20) NULL,
  `feNac` DATE NULL,
  `sexo` VARCHAR(10) NULL,
  `estadoCivil` VARCHAR(20) NULL,
  `telefono` VARCHAR(10) NOT NULL,
  `correo` VARCHAR(60) NOT NULL,
  `domicilio` TEXT NULL,
  PRIMARY KEY (`idEmp`));
  
CREATE TABLE `bdsapac`.`entrega` (
  `idE` INT NOT NULL auto_increment,
  `acuseE` TEXT NULL,
  `estado` VARCHAR(20) NOT NULL,
  `feEn` DATE NULL,
  `notasEn` TEXT NULL,
  `idEmp` INT NOT NULL,
  PRIMARY KEY (`idE`, `idEmp`),
    FOREIGN KEY (`idEmp`)
    REFERENCES `bdsapac`.`empleado` (`idEmp`)
);
drop table if exists recepcion;
CREATE TABLE `bdsapac`.`recepcion` (
  `idR` INT NOT NULL auto_increment,
  `acuseR` TEXT NULL,
  `estado` VARCHAR(20) NOT NULL,
  `feREnt` DATE NULL,
  `notas` TEXT NULL,
  `idEmp` INT NOT NULL,
  PRIMARY KEY (`idR`, `idEmp`),
    FOREIGN KEY (`idEmp`)
    REFERENCES `bdsapac`.`empleado` (`idEmp`)
);

drop table if exists dpinicial;
CREATE TABLE `bdsapac`.`dpinicial` (
  `id_DPI` INT NOT NULL auto_increment,
  `acuse` TEXT NULL,
  `estado` VARCHAR(20) NOT NULL,
  `fechaDeEntrega` DATE NULL,
  `observaciones` TEXT NULL,
  `idEmp` INT NOT NULL,
  PRIMARY KEY (`id_DPI`,`idEmp`),
    FOREIGN KEY (`idEmp`)
    REFERENCES `bdsapac`.`empleado` (`idEmp`)
);

drop table if exists dpconclusion;
CREATE TABLE `bdsapac`.`dpconclusion` (
  `id_DPC` INT NOT NULL auto_increment,
  `acuse` TEXT NULL,
  `estado` VARCHAR(20) NOT NULL,
  `fechaDeEntrega` DATE NULL,
  `observaciones` TEXT NULL,
  `idEmp` INT NOT NULL,
  PRIMARY KEY (`id_DPC`,`idEmp`),
    FOREIGN KEY (`idEmp`)
    REFERENCES `bdsapac`.`empleado` (`idEmp`)
);

drop table if exists dpmayo;
CREATE TABLE `bdsapac`.`dpmayo` (
  `id_DPM` INT NOT NULL auto_increment,
  `acuse` TEXT NULL,
  `estado` VARCHAR(20) NOT NULL,
  `fechaDeEntrega` DATE NULL,
  `observaciones` TEXT NULL,
  `idEmp` INT NOT NULL,
  PRIMARY KEY (`id_DPM`,`idEmp`),
    FOREIGN KEY (`idEmp`)
    REFERENCES `bdsapac`.`empleado` (`idEmp`)
);

CREATE TABLE `bdsapac`.`contrato` (
  `idCont` INT NOT NULL auto_increment,
  `rfc` VARCHAR(13) NULL,
  `departamento` VARCHAR(45) NOT NULL,
  `puesto` VARCHAR(20) NOT NULL,
  `sueldo` FLOAT NOT NULL,
  `feIn` DATE NOT NULL,
  `feTer` DATE NULL,
  `estatus` VARCHAR(9) NULL,
  `idEmp` INT NOT NULL,
  PRIMARY KEY (`idCont`, `idEmp`),
    FOREIGN KEY (`idEmp`)
    REFERENCES `bdsapac`.`empleado` (`idEmp`)
);

CREATE TABLE `bdsapac`.`perfiles` (
  `idP` INT NOT NULL auto_increment,
  `usuarios` VARCHAR(20) NULL,
  `contrasena` VARCHAR(255) NULL, -- hash de password_hash(); nunca la contraseña en claro
  `idCont` INT NOT NULL,
  PRIMARY KEY (`idP`, `idCont`),
    FOREIGN KEY (`idCont`)
    REFERENCES `bdsapac`.`contrato` (`idCont`)
    );

CREATE TABLE `bdsapac`.`buzon` (
  `idB` INT NOT NULL auto_increment,
  `feBu` DATE NOT NULL,
  `nombreCompleto` VARCHAR(100) NULL,
  `telefono` VARCHAR(10) NULL,
  `domicilio` VARCHAR(100) NULL,
  `cuenta` VARCHAR(9) NULL,
  `motivo` TEXT NOT NULL,
  `nomCompResp` VARCHAR(45) NULL,
  `hechos` TEXT NOT NULL,
  `pruebas` VARCHAR(4) NULL,
  `especificacion` TEXT NULL,
  `estatus` VARCHAR(45) NULL,
  PRIMARY KEY (`idB`));


CREATE TABLE `bdsapac`.`investigacion` (
  `idI` INT NOT NULL auto_increment,
  `titulo` VARCHAR(45) NULL,
  `feInicio` DATE NOT NULL,
  `feTermino` DATE NULL,
  `responsable` VARCHAR(45) NULL,
  `estatus` VARCHAR(45) NOT NULL,
  `retroalimentacion` TEXT NULL,
  `idB` INT NULL,
  `idCont` INT NULL,
  PRIMARY KEY (`idI`),
    FOREIGN KEY (`idB`)
    REFERENCES `bdsapac`.`buzon` (`idB`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
    FOREIGN KEY (`idCont`)
    REFERENCES `bdsapac`.`contrato` (`idCont`)
    ON DELETE SET NULL
    ON UPDATE CASCADE);
    
CREATE TABLE `bdsapac`.`historial` (
  `idH` INT NOT NULL auto_increment,
  `texto` TEXT NULL,
  PRIMARY KEY (`idH`));
  
  
#-------------------------------------------------------------------------------------


/* Para generar el nombre de usuario una vez que se ingrese un empleado */
drop trigger if exists GenerarUsuario;
delimiter //
create trigger GenerarUsuario after insert on contrato
for each row
begin
    declare nom varchar(2);
    declare ape varchar(4);
    declare anioinicio varchar(4);
    declare usuariofinal varchar(20);

    #obtener las primeras 2 letras del nombre del empleado
    select upper(substring(e.nombre, 1, 2)) into nom
    from empleado e
    where e.idemp = new.idemp;

    #obtener las primeras 4 letras del apellido paterno del empleado
    select upper(substring(e.apellidop, 1, 4)) into ape
    from empleado e
    where e.idemp = new.idemp;

    #obtener el año de inicio del contrato
    set anioinicio = year(new.fein);

    #concatenar las partes para formar el usuario en mayúsculas
    set usuariofinal = concat(nom, ape, anioinicio, new.idcont);

    #insertar el usuario en la tabla perfiles
    insert into perfiles (usuarios, idcont) 
    values (usuariofinal, new.idcont);
end //


/* Disparador para actualizar automáticamente la fecha de término (feTer) en la tabla
contrato cuando el campo estatus se actualice a "Inactivo": */
drop trigger if exists actualizarfechatermino;
delimiter //
create trigger actualizarfechatermino
before update on contrato
for each row
begin
    if new.estatus = 'Inactivo' then
        set new.feter = curdate();
    end if;
end //


-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
											/*HABILITAR DECLARACIONES PATRIMONIALES*/
                                            
-- Función para añadir 60 días hábiles a feIn y verificar si la fecha actual está dentro del rango
DROP FUNCTION IF EXISTS rangoDPinicio;
DELIMITER //
CREATE FUNCTION rangoDPinicio(con_id INT) RETURNS BOOLEAN
BEGIN
    DECLARE feInicio DATE;
    DECLARE fecha_final DATE;
    DECLARE contador INT DEFAULT 0;

    -- Obtener feIn de la tabla contrato 
    SELECT feIn INTO feInicio
    FROM contrato
    WHERE idcont = con_id;

    -- Validar si feIn es NULL (por si el idcont no existe en contrato)
    /*IF feInicio IS NULL THEN
        RETURN FALSE;
    END IF;*/

    SET fecha_final = feInicio;

    -- Agregar 60 días hábiles a feIn
    WHILE contador < 60 DO
        SET fecha_final = DATE_ADD(fecha_final, INTERVAL 1 DAY);
        IF DAYOFWEEK(fecha_final) NOT IN (1, 7) THEN -- 1 = Domingo, 7 = Sábado
            SET contador = contador + 1;
        END IF;
    END WHILE;

    -- Verificar si la fecha actual está entre feIn y fecha_final
    RETURN (CURRENT_DATE BETWEEN feInicio AND fecha_final);
END//

-- Función para añadir 60 días hábiles a feTer y verificar si la fecha actual está dentro del rango
drop function if exists rangoDPtermino;
DELIMITER //
CREATE FUNCTION rangoDPtermino(con_id INT) RETURNS BOOLEAN
BEGIN
    DECLARE feTermino DATE;
    DECLARE fecha_final DATE;
    DECLARE contador INT DEFAULT 0;

    -- Obtener feIn de la tabla contrato para el empleado dado
    SELECT feTer INTO feTermino
    FROM contrato
    WHERE idcont = con_id;

    -- Validar si feIn es NULL (por si el idEmp no existe en contrato)
    IF feTermino IS NULL THEN
        RETURN FALSE;
    END IF;

    SET fecha_final = feTermino;

    -- Agregar 60 días hábiles a feTer
    WHILE contador < 60 DO
        SET fecha_final = DATE_ADD(fecha_final, INTERVAL 1 DAY);
        IF DAYOFWEEK(fecha_final) NOT IN (1, 7) THEN -- 1 = Domingo, 7 = Sábado
            SET contador = contador + 1;
        END IF;
    END WHILE;

    -- Verificar si la fecha actual está entre feIn y fecha_final
    RETURN (CURRENT_DATE BETWEEN feTermino AND fecha_final);
END//


-- Función para verificar si estamos en el mes de mayo
drop function if exists es_mayo;
DELIMITER //
CREATE FUNCTION es_mayo() RETURNS BOOLEAN
BEGIN
    RETURN (MONTH(CURRENT_DATE) = 5);
END//


-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
											/*HABILITAR ENTREGAS*/
DROP FUNCTION IF EXISTS rangoEntrega;
DELIMITER //

CREATE FUNCTION rangoEntrega(con_id INT) RETURNS BOOLEAN
BEGIN
    DECLARE feTermino DATE;
    DECLARE fecha_inicio DATE;
    DECLARE fecha_final DATE;
    DECLARE contador INT DEFAULT 0;

    -- Obtener feTer de la tabla contrato para el empleado dado
    SELECT feTer INTO feTermino
    FROM contrato
    WHERE idcont = con_id;

    -- Validar si feTer es NULL (por si el idcont no existe en contrato)
    IF feTermino IS NULL THEN
        RETURN FALSE;
    END IF;

    -- Comenzar desde el próximo día hábil si la separación es en viernes
    IF DAYOFWEEK(feTermino) = 6 THEN -- 6 = Viernes
        SET fecha_inicio = DATE_ADD(feTermino, INTERVAL 3 DAY); -- Mover a lunes
    ELSE
        SET fecha_inicio = DATE_ADD(feTermino, INTERVAL 1 DAY); -- Día siguiente
    END IF;

    SET fecha_final = fecha_inicio;

    -- Agregar 15 días hábiles a partir de fecha_inicio
    WHILE contador < 15 DO
        SET fecha_final = DATE_ADD(fecha_final, INTERVAL 1 DAY);
        IF DAYOFWEEK(fecha_final) NOT IN (1, 7) THEN -- 1 = Domingo, 7 = Sábado
            SET contador = contador + 1;
        END IF;
    END WHILE;

    -- Verificar si la fecha actual está dentro del rango
    RETURN (CURRENT_DATE BETWEEN fecha_inicio AND fecha_final);
END//


-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
											/*HABILITAR RECEPCION*/
DROP FUNCTION IF EXISTS rangoRecepción;
DELIMITER //

CREATE FUNCTION rangoRecepción(con_id INT) RETURNS BOOLEAN
BEGIN
    DECLARE feInicio DATE;
    DECLARE fecha_inicio DATE;
    DECLARE fecha_final DATE;
    DECLARE contador INT DEFAULT 0;

    -- Obtener feTer de la tabla contrato para el empleado dado
    SELECT feIn INTO feInicio
    FROM contrato
    WHERE idcont = con_id;

    -- Validar si feTer es NULL (por si el idcont no existe en contrato)
    IF feInicio IS NULL THEN
        RETURN FALSE;
    END IF;

    -- Comenzar desde el próximo día hábil si la separación es en viernes
    IF DAYOFWEEK(feInicio) = 6 THEN -- 6 = Viernes
        SET fecha_inicio = DATE_ADD(feInicio, INTERVAL 3 DAY); -- Mover a lunes
    ELSE
        SET fecha_inicio = DATE_ADD(feInicio, INTERVAL 1 DAY); -- Día siguiente
    END IF;

    SET fecha_final = fecha_inicio;

    -- Agregar 15 días hábiles a partir de fecha_inicio
    WHILE contador < 30 DO
        SET fecha_final = DATE_ADD(fecha_final, INTERVAL 1 DAY);
        IF DAYOFWEEK(fecha_final) NOT IN (1, 7) THEN -- 1 = Domingo, 7 = Sábado
            SET contador = contador + 1;
        END IF;
    END WHILE;

    -- Verificar si la fecha actual está dentro del rango
    RETURN (CURRENT_DATE BETWEEN fecha_inicio AND fecha_final);
END//

-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

									/*Actualizar tablas para subir documentacion*/
                                    
                                    
-- Disparador que Inserta en la tabla depatrimonial y recepcion el estado "sin entregar" cuando alguien ingresa                                
drop trigger if exists prueba;
DELIMITER $$
CREATE TRIGGER prueba
AFTER INSERT ON contrato
FOR EACH ROW
BEGIN
    INSERT INTO dpinicial (estado, idEmp)
    VALUES ('Sin entregar', NEW.idEmp);
    INSERT INTO recepcion (estado, idEmp)
    VALUES ('Sin entregar', NEW.idEmp);
END$$
DELIMITER ;

-- Disparador que Inserta en la tabla dpconclusion y entrega el estado "sin entregar" cuando alguien Termina su contrato    
drop trigger if exists prueba2;
DELIMITER $$
CREATE TRIGGER prueba2
AFTER UPDATE ON contrato
FOR EACH ROW
BEGIN
    IF NEW.estatus = 'Inactivo' AND NEW.feTer IS NOT NULL THEN
        INSERT INTO dpconclusion (estado, idEmp)
        VALUES ('Sin entregar', NEW.idEmp);
        INSERT INTO entrega (estado, idEmp)
        VALUES ('Sin entregar', NEW.idEmp);
    END IF;
END$$
DELIMITER ;

-- Evento que Inserta en la tabla dpmayo el estado "sin entregar" en mayo de cada año
drop EVENT if exists insertar_dpmayo;
DELIMITER $$
CREATE EVENT insertar_dpmayo
ON SCHEDULE EVERY 1 YEAR -- CAMBIAR SI ES CADA AÑO, DIA, HORA, ETC.
STARTS '2025-05-01 00:00:00'
DO
BEGIN
    -- Insertar para todos los empleados
    INSERT INTO dpmayo (estado, idEmp)
    SELECT 'Sin entregar', idEmp
    FROM empleado
    WHERE NOT EXISTS (
        SELECT 1 
        FROM dpmayo 
        WHERE idEmp = empleado.idEmp
          AND YEAR(fechaDeEntrega) = YEAR(CURDATE())
          AND MONTH(fechaDeEntrega) = 5
    );
END$$


-- Evento que elimina en la tabla dpmayo todos los registros que tengan "sin entregar" 
drop EVENT if exists eliminar_sin_entregar;
DELIMITER $$
CREATE EVENT IF NOT EXISTS eliminar_sin_entregar
ON SCHEDULE EVERY 1 YEAR -- CAMBIAR SI ES CADA AÑO, DIA, HORA, ETC.
STARTS '2025-04-30 00:00:00'
DO
BEGIN
    DELETE FROM dpmayo
    WHERE estado = 'Sin entregar';
END$$

SHOW EVENTS FROM bdsapac;

#--------------------------------------------------------------------------------------------------------------------------------------------------------------
	
																				#DISPARADORES PARA LOS HISTORIALES
#Empleados
drop trigger if exists InHisEmp;
delimiter //
create trigger InHisEmp after insert on empleado
for each row
begin
	insert into historial values (0,
	concat_ws(" ", "Registro de Empleado", new.nombre, new.apellidoP, new.telefono,
    "Realizado por: ", user(), "Fecha; ", now()));
end //
select * from historial;

#Actualizacion de Empleados
drop trigger if exists UpHisEmp;
delimiter //
create trigger UpHisEmp after update on empleado
for each row
begin
	insert into historial values (0,
	concat_ws(" ", "Actualización de Empleado", new.nombre, new.apellidoP, new.telefono,
    "Realizado por: ", user(), "Fecha; ", now()));
end //
select * from historial;

#Contratos
drop trigger if exists InHisCont;
delimiter //
create trigger InHisCont after insert on contrato
for each row
begin
	insert into historial values (0,
	concat_ws(" ", "Registro de Contrato", new.departamento, new.puesto, new.feIn, new.estatus,
    "Realizado por: ", user(), "Fecha; ", now()));
end //
select * from historial;

#Cambios en Contratos
drop trigger if exists UpHisCont;
delimiter //
create trigger UpHisCont after update on contrato
for each row
begin
	insert into historial values (0,
	concat_ws(" ", "Actualización de Contrato", new.departamento, new.puesto, 
    new.feIn,new.feTer, new.estatus,
    "Realizado por: ", user(), "Fecha; ", now()));
end //
select * from historial;


#investigaciones
drop trigger if exists InHisInv;
delimiter //
create trigger InHisInv after insert on investigacion
for each row
begin
	insert into historial values (0,
	concat_ws(" ", "Registro de Investigaciones", new.titulo, new.feInicio, new.responsable,
	new.estatus, new.retroalimentacion,
    "Realizado por: ", user(), "Fecha; ", now()));
end //
select * from historial;

#Actualizaciones de investigaciones
drop trigger if exists UpHisInv;
delimiter //
create trigger UpHisInv after update on investigacion
for each row
begin
	insert into historial values (0,
	concat_ws(" ", "Actualizaciones de Investigaciones", new.titulo, 
    new.feInicio, new.feTermino, new.responsable,
	new.estatus, new.retroalimentacion,
    "Realizado por: ", user(), "Fecha; ", now()));
end //
select * from historial;

#perfiles
drop trigger if exists InHisPer;
delimiter //
create trigger InHisPer after insert on perfiles
for each row
begin
	insert into historial values (0,
	concat_ws(" ", "Registro de perfiles", new.usuarios,
    "Realizado por: ", user(), "Fecha; ", now()));
end //
select * from historial;

#Actualizaciones de perfiles
drop trigger if exists UpHisPer;
delimiter //
create trigger UpHisPer after update on perfiles
for each row
begin
	insert into historial values (0,
	concat_ws(" ", "Actualizacion de Perfil", new.usuarios,
    "Realizado por: ", user(), "Fecha; ", now()));
end //
select * from historial;


drop procedure if exists obtenerInvestigadores;
DELIMITER //
CREATE PROCEDURE obtenerInvestigadores()
BEGIN
    SELECT e.idEmp, CONCAT(e.nombre, ' ', e.apellidoP, ' ', e.apellidoM) AS nombreCompleto
	FROM Empleado e
	INNER JOIN Contrato c ON e.idEmp = c.idEmp
	WHERE c.puesto IN ('Investigador');
    
END //
CALL obtenerInvestigadores();

drop procedure if exists obtenerDatos;
DELIMITER //
CREATE PROCEDURE obtenerDatos()
BEGIN
    SELECT I.idI, b.idB, I.titulo, b.hechos, I.retroalimentacion, I.responsable, I.estatus
    FROM investigacion I
    INNER JOIN buzon b ON i.idB = b.idB;
END //
CALL obtenerDatos();

INSERT INTO `bdsapac`.`empleado` (`nombre`, `apellidoP`, `apellidoM`, `feNac`, `sexo`, `estadoCivil`, `telefono`, `correo`, `domicilio`) VALUES ( 'Sandra', 'Salgado', 'esquivel', '1999-09-23', 'F', 'soltero', '7771071541', 'correofalso@gmail.com', 'xxx');
INSERT INTO `bdsapac`.`empleado` (`nombre`, `apellidoP`, `apellidoM`, `feNac`, `sexo`, `estadoCivil`, `telefono`, `correo`, `domicilio`) VALUES ( 'Pedro', 'Perez', 'sanchez', '1999-09-23', 'M', 'casado', '7772583234', 'correofalso@gmail.com', 'xxx');
INSERT INTO `bdsapac`.`empleado` ( `nombre`, `apellidoP`, `apellidoM`, `feNac`, `sexo`, `estadoCivil`, `telefono`, `correo`, `domicilio`) VALUES ( 'Pedro', 'Perez', 'sanchez', '1999-10-24', 'M', 'divorciado', '7778529845', 'correofalso@gmail.com', 'xxx');
INSERT INTO `bdsapac`.`empleado` ( `nombre`, `apellidoP`, `apellidoM`, `feNac`, `sexo`, `estadoCivil`, `telefono`, `correo`, `domicilio`) VALUES ( 'Fernanda', 'Rosario', 'Patiño', '2000-01-25', 'F', 'viudo', '7777896512', 'correofalso@gmail.com', 'xxx');
INSERT INTO `bdsapac`.`empleado` ( `nombre`, `apellidoP`, `apellidoM`, `feNac`, `sexo`, `estadoCivil`, `telefono`, `correo`, `domicilio`) VALUES ( 'Maria', 'Galindo', 'Jimenez', '2002-05-26', 'F', 'separado', '7773697548', 'correofalso@gmail.com', 'xxx');

INSERT INTO `bdsapac`.`contrato` ( `rfc`, `departamento`, `puesto`, `sueldo`, `feIn`, `estatus`, `idEmp`) VALUES ( 'PEGJ850315XXX', 'Recursos Humanos', 'secretaria RH', '2000', '2024-10-10', 'Activo', '1');
INSERT INTO `bdsapac`.`contrato` ( `rfc`, `departamento`, `puesto`, `sueldo`, `feIn`, `estatus`, `idEmp`) VALUES ( 'PEGJ850315XXX', 'Investigaciones', 'Investigador', '2500', '2024-11-06', 'Activo', '2');
INSERT INTO `bdsapac`.`contrato` ( `rfc`, `departamento`, `puesto`, `sueldo`, `feIn`, `estatus`, `idEmp`) VALUES ( 'PEGJ850315XXX', 'RH', 'contadora', '5000', '2024-10-30', 'Activo', '3');
INSERT INTO `bdsapac`.`contrato` ( `rfc`, `departamento`, `puesto`, `sueldo`, `feIn`, `feTer`, `estatus`, `idEmp`) VALUES ('PEGJ850315XXX', 'Comisaria', 'Comisario', '6800', '2024-05-20', '2024-11-10', 'Inactivo', '4');
INSERT INTO `bdsapac`.`contrato` ( `rfc`, `departamento`, `puesto`, `sueldo`, `feIn`, `feTer`, `estatus`, `idEmp`) VALUES ( 'PEGJ850315XXX', 'RH', 'admin', '7000', '2024-05-20', '2024-10-10', 'Inactivo', '5');
select * from empleado;
select * from contrato;
select * from perfiles;
select * from dpinicial;
select * from dpconclusion;
select * from dpmayo;
select * from entrega;
select * from recepcion;
select * from buzon;

use bdsapac;
