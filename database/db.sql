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
    CONSTRAINT pk_msjwhatsapp PRIMARY KEY(msjwhatsapp),
    CONSTRAINT fk_msjwhatsapp_usuario FOREIGN KEY(us_id) REFERENCES usuario(id_us)
)ENGINE = InnoDb;