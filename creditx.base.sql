-- Creación de la base de datos
CREATE DATABASE creditx DEFAULT CHARACTER SET utf8;
USE creditx;
-- Creación del usuario creditx_adm, autorización de permisos
CREATE USER creditx_adm IDENTIFIED BY 'soundsgood';
GRANT ALL PRIVILEGES ON creditx.* TO 'creditx_adm'@'localhost' IDENTIFIED BY 'soundsgood';
FLUSH PRIVILEGES;
-- Crear Tablas
CREATE TABLE tb_generaciones (
    generacion INT(4) UNSIGNED NOT NULL PRIMARY KEY,
    grado INT(2) UNSIGNED NOT NULL,
    fechac DATETIME DEFAULT NOW() NOT NULL
);
CREATE TABLE tb_carreras (
    carrera VARCHAR(10) NOT NULL PRIMARY KEY,
    descr VARCHAR(50),
    fechac DATETIME DEFAULT NOW() NOT NULL
);
CREATE TABLE tb_grupos (
    grupoid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    generacion INT(4) UNSIGNED NOT NULL,
    carrera VARCHAR(10) NOT NULL,
    grupo VARCHAR(5) NOT NULL,
    especialidad VARCHAR(20) NOT NULL,
    fechac DATETIME DEFAULT NOW() NOT NULL
);
CREATE TABLE tb_alumnos (
    matricula VARCHAR(10) NOT NULL PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellidop VARCHAR(50) NOT NULL,
    apellidom VARCHAR(50) NOT NULL,
    grupoid INT UNSIGNED NOT NULL,
    genero VARCHAR(1) NOT NULL,
    fechan DATE NOT NULL,
    fechac DATETIME DEFAULT NOW() NOT NULL
);
CREATE TABLE tb_actividades (
    actividadid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(20) NOT NULL,
    descr VARCHAR(50),
    cantidad INT(3) NOT NULL,
    fechac DATETIME DEFAULT NOW() NOT NULL
);
CREATE TABLE tb_creditos (
    creditoid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    actividadid INT UNSIGNED NOT NULL,
    matricula VARCHAR(10) NOT NULL,
    cantidad INT(3) NOT NULL,
    fechac DATETIME DEFAULT NOW() NOT NULL
);
CREATE TABLE tb_tarjetas (
    rfid VARCHAR(10) NOT NULL PRIMARY KEY,
    matricula VARCHAR(10) NOT NULL,
    estado BOOLEAN NOT NULL DEFAULT 1,
    fechac DATETIME DEFAULT NOW() NOT NULL
);
-- Insertar Claves Foraneas
ALTER TABLE tb_grupos ADD CONSTRAINT fk1 FOREIGN KEY (generacion) REFERENCES tb_generaciones (generacion);
ALTER TABLE tb_grupos ADD CONSTRAINT fk2 FOREIGN KEY (carrera) REFERENCES tb_carreras (carrera);
ALTER TABLE tb_alumnos ADD CONSTRAINT fk3 FOREIGN KEY (grupoid) REFERENCES tb_grupos (grupoid);
ALTER TABLE tb_creditos ADD CONSTRAINT fk4 FOREIGN KEY (matricula) REFERENCES tb_alumnos (matricula);
ALTER TABLE tb_creditos ADD CONSTRAINT fk5 FOREIGN KEY (actividadid) REFERENCES tb_actividades (actividadid);
ALTER TABLE tb_tarjetas ADD CONSTRAINT fk6 FOREIGN KEY (matricula) REFERENCES tb_alumnos (matricula);
-- Crear Vistas
CREATE VIEW vw_grupos AS
SELECT tb_grupos.grupoid, CONCAT(tb_generaciones.grado, "° ", tb_grupos.grupo, " ", tb_grupos.carrera, " ", tb_grupos.especialidad) as gruponom, tb_grupos.generacion, tb_grupos.carrera, tb_generaciones.grado, tb_grupos.grupo, tb_grupos.especialidad, tb_grupos.fechac
FROM tb_grupos INNER JOIN tb_generaciones ON tb_grupos.generacion = tb_generaciones.generacion;
--
CREATE VIEW vw_alumnos AS
SELECT tb_alumnos.matricula, CONCAT(tb_alumnos.nombre, " ", tb_alumnos.apellidop, " ", tb_alumnos.apellidom) as nombrecom, tb_alumnos.nombre, tb_alumnos.apellidop, tb_alumnos.apellidom, vw_grupos.grupoid, vw_grupos.gruponom, tb_alumnos.genero, IF(SUM(tb_creditos.cantidad) IS NULL, 0, SUM(tb_creditos.cantidad)) as creditos, tb_alumnos.fechan, tb_alumnos.fechac
FROM vw_grupos INNER JOIN ( tb_alumnos LEFT JOIN tb_creditos ON tb_alumnos.matricula = tb_creditos.matricula ) ON tb_alumnos.grupoid = vw_grupos.grupoid GROUP BY tb_alumnos.matricula;
--
CREATE VIEW vw_creditos AS
SELECT tb_creditos.creditoid, tb_creditos.actividadid, tb_actividades.titulo, tb_creditos.matricula, vw_alumnos.nombrecom, vw_alumnos.gruponom, tb_creditos.cantidad, tb_creditos.fechac
FROM tb_actividades INNER JOIN (tb_creditos INNER JOIN vw_alumnos ON tb_creditos.matricula = vw_alumnos.matricula) 
ON tb_actividades.actividadid = tb_creditos.actividadid;
--
CREATE VIEW vw_tarjetas AS
SELECT tb_tarjetas.rfid, tb_tarjetas.matricula, vw_alumnos.nombrecom, vw_alumnos.gruponom, tb_tarjetas.estado, tb_tarjetas.fechac
FROM tb_tarjetas INNER JOIN vw_alumnos ON tb_tarjetas.matricula = vw_alumnos.matricula;