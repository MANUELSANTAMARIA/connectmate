CREATE DATABASE connectmate COLLATE = utf8_unicode_ci;

use connectmate

CREATE TABLE
    tipo_usuario(
        id_tipo_us INT(255) AUTO_INCREMENT NOT NULL,
        nombre_tipo_us varchar(100) NOT NULL,
        CONSTRAINT pk_tipo_usuario PRIMARY KEY(id_tipo_us)
    ) ENGINE = InnoDB;
INSERT INTO
    tipo_usuario (nombre_tipo_us)
VALUES ('Root'), ('Administrador'), ('Vendedor'), ('Impulsador'), ('Bodega');


CREATE TABLE 
        estado_usuario(
            id_estado_us INT AUTO_INCREMENT NOT NULL,
            nombre_estado_us varchar(70) NOT NULL,
            CONSTRAINT pk_id_estado_us PRIMARY KEY(id_estado_us)
        )ENGINE = InnoDb;

INSERT INTO
    estado_usuario(nombre_estado_us)
VALUES ("Habilitado"), ("Deshabilitado");

CREATE TABLE
    usuario(
        id_us INT(255) auto_increment NOT NULL,
        nombre_us varchar(50) NOT NULL,
        apellido_us varchar(50) NOT NULL,
        edad_us DATE NOT NULL,
        ci_us VARCHAR(10) NOT NULL,
        email_us varchar(100) NOT NULL,
        contrasena_us varchar(100) NOT NULL,
        tipo_us_id int(255) NOT NULL,
        estado_us_id int(255) NOT NULL,
        avatar VARCHAR(255),
        creado_en DATETIME,
        actualizado_en DATETIME,
        CONSTRAINT pk_usuario PRIMARY KEY(id_us),
        CONSTRAINT uq_email_us UNIQUE(email_us),
        CONSTRAINT fk_usuario_tipo_usuario FOREIGN KEY(tipo_us_id) REFERENCES tipo_usuario(id_tipo_us),
        CONSTRAINT fk_usuario_estado_usuario FOREIGN KEY(estado_us_id) REFERENCES estado_usuario(id_estado_us)
    )ENGINE = InnoDb;

INSERT INTO
    usuario(
        nombre_us,
        apellido_us,
        edad_us,
        ci_us,
        email_us,
        contrasena_us,
        tipo_us_id,
        estado_us_id,
        creado_en     
    )
 VALUES (
        "Manuel",
        "Santamaria",
        "1997-01-10",
        "099999",
        "1",
        "1",
        1,
        1,
        '2024-01-05'
    );



-- PRODUCTO
CREATE TABLE categoria(
    id_categoria int auto_increment NOT NULL,
    nombre_categoria VARCHAR(70) NOT NULL,
    CONSTRAINT pk_categoria PRIMARY KEY(id_categoria)
)ENGINE = InnoDb;

INSERT INTO categoria(nombre_categoria) 
    VALUES ("SMARTPHONE"), ("FIJO"), ("TV");


CREATE TABLE marca(
    id_marca INT auto_increment NOT NULL,
    nombre_marca VARCHAR(70) NOT NULL,
    CONSTRAINT pk_id_marca PRIMARY KEY(id_marca)
)ENGINE = InnoDb;

INSERT INTO marca(nombre_marca) 
VALUES ('SAMSUNG'), ('APPLE'), ('HUAWEI'), ('XIAOMI'), ('HONOR'), ("TCL"), ("CNT");

-- CREATE TABLE regalo(
--     id_regalo int auto_increment NOT NULL,
--     nombre_regalo VARCHAR(70) NOT NULL,
--     CONSTRAINT pk_regalo PRIMARY KEY(id_regalo)
-- )ENGINE = InnoDb;
-- INSERT INTO regalo(nombre_regalo) 
--     VALUES ("SIN REGALO"), ("TOMATODOS"), ("CUBRE CARRO"), ("AUDIFONOS");


CREATE TABLE smartflex(
    id_smartflex INT AUTO_INCREMENT NOT NULL,
    cod_smartflex VARCHAR(5),
    nombre_smartflex VARCHAR(255),
    CONSTRAINT pk_smartflex PRIMARY KEY(id_smartflex),
    CONSTRAINT uq_cod_smartflex UNIQUE(cod_smartflex)
)ENGINE = InnoDb;

INSERT INTO smartflex(cod_smartflex, nombre_smartflex) VALUES
("0001", "HUAWEI NOVA Y70 MGA-LX3"),
("0002", "KIT TV PREPAGO PARA LA VENTA"),
("0003", "256K SIM 4G/LTE 2FF/3FF/4FF NO/ROMNG MVL"),
('3143', 'HONOR 90 (REA-NX9)'),
('3144', 'HONOR 90 LITE (CRT-NX3)'),
('8717', 'HONOR MAGIC 5 PRO (PGT-N19)'),
('8699', 'HONOR MAGIC5 LITE (RMO-NX3)'),
('8707', 'SAMSUNG GALAXY A34SM-A346M/DSN'),
("8721", "SAMSUNG Z FLIP 5 (SM-F731B)"),
("8689", "XIAOMI 12 LITE (2203129G)"),
("8691", "ALCATEL LINKZONE (MW45AN)"),
("8698", "HONOR X8A (CRT-LX3)"),
("8486", "HUAWEI NOVA 9se (JLN-LX3) "),
( "8719", "INFINIX HOT 30 I"),
("8720", "INFINIX NOTE 30 PRO"),
("8495", "NOKIA G21(TA-1412)"),
("8718", "REALME C55 (RMX3710)"),
("8724", "SAMSUNG A04 (SM-A045M/DS)"),
("8723" ,"SAMSUNG A14 (SM-A145M/DS)"),
("8708", "SAMSUNG GALAXY A54 SM-A546E/DS"),
("8690", "SAMSUNG S23 PLUS (SM-S916B/DS)"),
("8700", "TCL 40SE (T610E)");



CREATE TABLE gama(
    id_gama int auto_increment NOT NULL,
    nombre_gama VARCHAR(70) NOT NULL,
    CONSTRAINT pk_gama PRIMARY KEY(id_gama)
)ENGINE = InnoDb;

INSERT INTO gama(nombre_gama) VALUES ("GAMA PREMIUM"), ("GAMA ALTA"), ("GAMA MEDIA"), ("GAMA BAJA");


CREATE TABLE producto(
    id_producto INT AUTO_INCREMENT NOT NULL,
    cod_producto VARCHAR(10) NOT NULL,
    categoria_id INT NOT NULL,
    marca_id INT NOT NULL,
    nombre_producto VARCHAR(100) NOT NULL,
    descripcion_producto text,
    precio FLOAT(100,2) NOT NULL,
    stock  INT(255) NOT NULL,
    oferta VARCHAR(70),
    smartflex_cod VARCHAR(5) NOT NULL,
    gama_id INT NOT NULL,
    imagen varchar(255),
    creado_en TIMESTAMP,
    actualizado_en TIMESTAMP,
    CONSTRAINT pk_producto PRIMARY KEY(id_producto),
    CONSTRAINT uq_cod_producto UNIQUE(cod_producto),
    CONSTRAINT fk_categoria_id FOREIGN KEY(categoria_id) REFERENCES categoria(id_categoria),
    CONSTRAINT fk_marca_id FOREIGN KEY(marca_id) REFERENCES marca(id_marca),
    CONSTRAINT fk_smartflex_cod FOREIGN KEY(smartflex_cod) REFERENCES smartflex(cod_smartflex),
    CONSTRAINT fk_gama_id FOREIGN KEY(gama_id) REFERENCES gama(id_gama)
)ENGINE = InnoDb;




CREATE TABLE cotizacion (
    id_cotizacion INT AUTO_INCREMENT NOT NULL,
    nombre_cotizacion VARCHAR(70) NOT NULL,
    valor_cotizacion FLOAT(100,2) NOT NULL,
    CONSTRAINT pk_id_cotizacion PRIMARY KEY (id_cotizacion)
) ENGINE = InnoDB;

INSERT INTO cotizacion (id_cotizacion, nombre_cotizacion, valor_cotizacion) VALUES
(1, 'TASA DE INTERÉS', 16.23),
(2, 'INTERÉS MENSUAL', 1.26),
(3, 'VALOR DEL IVA', 12.00);

CREATE TABLE rol_plan (
    id_rol_plan INT AUTO_INCREMENT NOT NULL,
    nombre_rol_plan VARCHAR(150),
    CONSTRAINT pk_id_rol_plan PRIMARY KEY(id_rol_plan)
)ENGINE = InnoDB;

INSERT INTO rol_plan (id_rol_plan, nombre_rol_plan) VALUES
(1, 'PLANES MASIVOS - CLIENTES MASIVOS'),
(2, 'PLAN ROL DE PAGOS - COLABORADORES INTERNO'),
(3, 'PLANES CORPORATIVOS - EMPRESAS');


CREATE TABLE tipo_transaccion(
    id_tipo_transaccion INT AUTO_INCREMENT NOT NULL,
    nombre_tipo_transaccion VARCHAR(150),
    CONSTRAINT pk_id_tipo_transaccion PRIMARY KEY(id_tipo_transaccion)
)ENGINE = InnoDB;

INSERT INTO tipo_transaccion(id_tipo_transaccion, nombre_tipo_transaccion) VALUES
(1, "entrada"),
(2, "salida");

CREATE TABLE kardex(
    id_kardex INT AUTO_INCREMENT NOT NULL,
    producto_cod VARCHAR(10) NOT NULL,
    tipo_transaccion_id INT NOT NULL,
    unidad INT NOT NULL,
    fecha DATETIME NOT NULL,
    CONSTRAINT pk_id_kardex PRIMARY KEY(id_kardex),
    CONSTRAINT fk_producto_cod FOREIGN KEY(producto_cod) REFERENCES producto(cod_producto),
    CONSTRAINT fk_tipo_transaccion_id FOREIGN KEY(tipo_transaccion_id) REFERENCES tipo_transaccion(id_tipo_transaccion)
)ENGINE = InnoDB;



CREATE TABLE plan(
    id_plan INT AUTO_INCREMENT NOT NULL,
    cod_plan VARCHAR(20) NOT NULL,
    nombre_plan VARCHAR(150) NOT NULL,
    cbm INT(10),
    tarifa_plan FLOAT(100,2) NOT NULL,
    equipo_diferido VARCHAR(50) NOT NULL,
    observacion VARCHAR(100) NOT NULL,
    rol_plan_id INT NOT NULL,
    CONSTRAINT pk_id_plan PRIMARY KEY(id_plan),
    CONSTRAINT uq_cod_plan UNIQUE(cod_plan),
    CONSTRAINT fk_cod_plan FOREIGN KEY(rol_plan_id) REFERENCES rol_plan(id_rol_plan)
)ENGINE = InnoDB;



-- Inserciones de datos actualizados
INSERT INTO plan (id_plan, cod_plan, nombre_plan, cbm, tarifa_plan, equipo_diferido, observacion, rol_plan_id) 
VALUES 
(NULL, '300529P1', 'Plan ilimitado Social Plus ($15,99 + imp)', '0', '15.99', 'SI', 'Verificar guía comercial', '1'), 
(NULL, '300529P2', 'Plan ilimitado Social Plus ($19,99 + imp)', '0', '19.99', 'SI', 'Verificar guía comercial', '1'),
(NULL, '300529P3', 'Plan ilimitado Social Plus ($21,99 + imp)', '0', '21.99', 'SI', 'Verificar guía comercial', '1'), 
(NULL, '300522P1', 'Plan Ultra navegación ($17,99 + imp)', '0', '17.99', 'SI', 'Verificar guía comercial', '1'),
(NULL, '300522P2', 'Plan móvil Ilimitado ($30,00 + imp)', '0', '30.00', 'SI', 'Verificar guía comercial', '1'),
(NULL, '300525P1', 'Plan Portabilidad ($12,99 + imp)', '0', '12.99', 'SI', 'Verificar guía comercial', '1'),
(NULL, '300516P1', 'Plan Móvil Más ($14,53 + imp)', '0', '14.53', 'SI', 'Verificar guía comercial', '1'),
(NULL, '300516P2', 'Plan Móvil Más ($17,78 + imp)', '0', '17.78', 'SI', 'Verificar guía comercial', '1'),
(NULL, '300516P3', 'Plan Móvil Más ($21,02 + imp)', '0', '21.02', 'SI', 'Verificar guía comercial', '1'),
(NULL, '300516P4', 'Plan Móvil Más ($25,08 + imp)', '0', '25.08', 'SI', 'Verificar guía comercial', '1'),
(NULL, '300515P1', 'Plan Servidor Público ($18,75 + imp)', '0', '18.75', 'SI', 'Verificar guía comercial', '1'),
(NULL, '300517P1', 'Plan Adulto Mayor ($5,95 + imp)', '0', '5.95', 'SI', 'Verificar guía comercial', '1'),
(NULL, '300516P5', 'Plan Móvil Ahorro ($10,47 + imp)', '0', '10.47', 'SI', 'Verificar guía comercial', '1'),
(NULL, '300516P6', 'Plan Móvil Ahorro ($12,91 + imp)', '0', '12.91', 'SI', 'Verificar guía comercial', '1'),
(NULL, '300298P1', 'Plan Discapacidad ($12,00 + imp)', '2', '12', 'SI', 'Verificar guía comercial', '1'),
(NULL, '999999P1', 'Rol de Pagos', '0' , '0.00', 'SI', 'Exclusivo para colaboradores internos', '2'),
(NULL, '30051457055708P1', 'Plan Modular (14,90 + imp)', '14.90', '0', 'SI', 'Tiempo mínimo de permanencia: 12 meses', '3'),
(NULL, '30051457055709P1', 'Plan Modular Starnet (19,90 + imp)', '19.90', '0', 'SI', 'Tiempo mínimo de permanencia: 12 meses', '3'),
(NULL, '30051457055710P1', 'Plan Modular ProConnect (24,90 + imp)', '24.90', '0', 'SI', 'Tiempo mínimo de permanencia: 12 meses', '3'),
(NULL, '30051457055711P1', 'Plan Modular EliteBusiness(29,90 + imp)', '29.90', '0', 'SI', 'Tiempo mínimo de permanencia: 12 meses', '3'),
(NULL, '30051457055712P1', 'Plan Modular (34,90 + imp)', '34.90', '0', 'SI', 'Tiempo mínimo de permanencia: 12 meses', '3'),
(NULL, '300514570557115712P1', 'Plan Modular (54,80 + imp)', '54.80', '0', 'SI', 'Tiempo mínimo de permanencia: 12 meses', '3'),
(NULL, '300531P1', 'PLAN INERTEN GRANDES CAPACIDADES SMART CONNECT PRO 12M 10 GB', '10.81', '0', 'MIFI', 'Exclusivo para captación y mantenimiento de cuentas corporativas. 12M', '3'),
(NULL, '300531P2', 'PLAN INERTEN GRANDES CAPACIDADES SMART CONNECT PRO 12M 12 GB', '11.37', '0', 'MIFI', 'Exclusivo para captación y mantenimiento de cuentas corporativas. 12M', '3'),
(NULL, '300531P3', 'PLAN INERTEN GRANDES CAPACIDADES SMART CONNECT PRO 12M 13 GB', '11.81', '0', 'MIFI', 'Exclusivo para captación y mantenimiento de cuentas corporativas. 12M', '3'),
(NULL, '300531P4', 'PLAN INERTEN GRANDES CAPACIDADES SMART CONNECT PRO 12M 15 GB', '13.42', '0', 'MIFI', 'Exclusivo para captación y mantenimiento de cuentas corporativas. 12M', '3'),
(NULL, '300531P5', 'PLAN INERTEN GRANDES CAPACIDADES SMART CONNECT PRO 12M 20 GB', '17.89', '0', 'MIFI', 'Exclusivo para captación y mantenimiento de cuentas corporativas. 12M', '3'),
(NULL, '300531P6', 'PLAN INERTEN GRANDES CAPACIDADES SMART CONNECT PRO 12M 47 GB', '31.50', '0', 'MIFI', 'Exclusivo para captación y mantenimiento de cuentas corporativas. 12M', '3'),
(NULL, '300531P7', 'PLAN INERTEN GRANDES CAPACIDADES SMART CONNECT PRO 12M 75 GB', '46.16', '0', 'MIFI', 'Exclusivo para captación y mantenimiento de cuentas corporativas. 12M', '3'),
(NULL, '300531P8', 'PLAN INERTEN GRANDES CAPACIDADES SMART CONNECT PRO 12M 80 GB', '49.23', '0', 'MIFI', 'Exclusivo para captación y mantenimiento de cuentas corporativas. 12M', '3'),
(NULL, '300531P9', 'PLAN INERTEN GRANDES CAPACIDADES SMART CONNECT PRO 12M 150 GB', '85.21', '0', 'MIFI', 'Exclusivo para captación y mantenimiento de cuentas corporativas. 12M', '3'),
(NULL, '300531P10', 'PLAN INERTEN GRANDES CAPACIDADES SMART CONNECT PRO 24M 10 GB', '8.65', '0', 'MIFI', 'Exclusivo para captación y mantenimiento de cuentas corporativas. 24M', '3'),
(NULL, '300531P11', 'PLAN INERTEN GRANDES CAPACIDADES SMART CONNECT PRO 24M 12 GB', '9.10', '0', 'MIFI', 'Exclusivo para captación y mantenimiento de cuentas corporativas. 24M', '3'),
(NULL, '300531P12', 'PLAN INERTEN GRANDES CAPACIDADES SMART CONNECT PRO 24M 13 GB', '9.80', '0', 'MIFI', 'Exclusivo para captación y mantenimiento de cuentas corporativas. 24M', '3'),
(NULL, '300531P13', 'PLAN INERTEN GRANDES CAPACIDADES SMART CONNECT PRO 24M 15 GB', '10.74', '0', 'MIFI', 'Exclusivo para captación y mantenimiento de cuentas corporativas. 24M', '3'),
(NULL, '300531P14', 'PLAN INERTEN GRANDES CAPACIDADES SMART CONNECT PRO 24M 20 GB', '14.32', '0', 'MIFI', 'Exclusivo para captación y mantenimiento de cuentas corporativas. 24M', '3'),
(NULL, '300531P15', 'PLAN INERTEN GRANDES CAPACIDADES SMART CONNECT PRO 24M 47 GB', '25.20', '0', 'MIFI', 'Exclusivo para captación y mantenimiento de cuentas corporativas. 24M', '3'),
(NULL, '300531P16', 'PLAN INERTEN GRANDES CAPACIDADES SMART CONNECT PRO 24M 75 GB', '36.93', '0', 'MIFI', 'Exclusivo para captación y mantenimiento de cuentas corporativas. 24M', '3'),
(NULL, '300531P17', 'PLAN INERTEN GRANDES CAPACIDADES SMART CONNECT PRO 24M 80 GB', '39.39', '0', 'MIFI', 'Exclusivo para captación y mantenimiento de cuentas corporativas. 24M', '3'),
(NULL, '300531P18', 'PLAN INERTEN GRANDES CAPACIDADES SMART CONNECT PRO 24M 150 GB', '68.17', '0', 'MIFI', 'Exclusivo para captación y mantenimiento de cuentas corporativas. 24M', '3');



CREATE TABLE msjwhatsapp(
    id_msjwhatsapp INT AUTO_INCREMENT NOT NULL,
    nombre VARCHAR(50),
    apellido VARCHAR(50),
    telefono VARCHAR(13),
    fecha DATETIME,
    mensaje TEXT,
    img VARCHAR(255),
    audio VARCHAR(255),
    video VARCHAR(255),
    us_id int(255) NOT NULL,
    CONSTRAINT pk_msjwhatsapp PRIMARY KEY(id_msjwhatsapp),
    CONSTRAINT fk_msjwhatsapp_usuario FOREIGN KEY(us_id) REFERENCES usuario(id_us)
)ENGINE = InnoDb;



CREATE TABLE contacto(
    id_contacto INT AUTO_INCREMENT NOT NULL,
    numero_contacto VARCHAR(12) NOT NULL,
    nombre VARCHAR(50),
    apellido VARCHAR(50),
    avatar VARCHAR(255),
    email_us varchar(100),
    CONSTRAINT pk_contacto PRIMARY KEY(id_contacto),
    CONSTRAINT uq_numero_contacto UNIQUE(numero_contacto)
)ENGINE = InnoDb;

CREATE TABLE tipo_mensaje(
    id_tipo_mensaje INT AUTO_INCREMENT NOT NULL,
    nombre_tipo_mensaje VARCHAR(50) NOT NULL,
    CONSTRAINT pk_tipo_mensaje PRIMARY KEY(id_tipo_mensaje)
)ENGINE = InnoDb;

CREATE TABLE conversacion_whatsapp(
    id_con_whatsapp INT AUTO_INCREMENT NOT NULL,
    cod_whatsapp VARCHAR(250) NOT NULL,
    mensaje TEXT,
    marca_tiempo DATETIME,
    numero_contacto VARCHAR(12) NOT NULL,
    tipo_mensaje_id INT NOT NULL,
    CONSTRAINT pk_conversacion_whatsapp PRIMARY KEY(id_con_whatsapp),
    CONSTRAINT uq_conversacion_whatsapp UNIQUE(cod_whatsapp),
    CONSTRAINT fk_conversacion_whatsapp_contacto FOREIGN KEY(numero_contacto) REFERENCES contacto(numero_contacto),
    CONSTRAINT fk_conversacion_whatsapp_tipo_mensaje FOREIGN KEY(tipo_mensaje_id) REFERENCES tipo_mensaje(id_tipo_mensaje)
)ENGINE = InnoDb;



