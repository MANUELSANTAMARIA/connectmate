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
VALUES ('Root'), ('Administrador'), ('Tecnico'), ('Administrador-Tecnico');


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



