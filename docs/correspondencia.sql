--------------
-- Entidades
--------------
-- PERSONA: Persona que remite o a quien se le envia el documento
CREATE TABLE persona (
    id_persona serial not null,
    nombres text not null,
    apellidos text not null,
    PRIMARY KEY (id_persona)
);

CREATE TABLE tipo_usuario (
  id_tipo_usuario integer not null,
  nombre varchar(64) not null,
  descripcion text null,
  PRIMARY KEY (id_tipo_usuario)
);

CREATE TABLE usuario (
  id_usuario serial not null,
  id_persona integer not null,
  id_tipo_usuario integer not null,
  fecha_registro timestamp not null default localtimestamp(0),
  login varchar(25) not null,
  clave varchar(32) not null,
  activo boolean not null,
  PRIMARY KEY (id_usuario),
  FOREIGN KEY (id_persona) REFERENCES persona (id_persona),
  FOREIGN KEY (id_tipo_usuario) REFERENCES tipo_usuario (id_tipo_usuario),
  UNIQUE (login)
);

-- ENTIDAD: Institucion que remite o a quien se le envia el documento
CREATE TABLE entidad (
    id_entidad serial not null,
    nombre text not null,
    direccion text null,
    telefono varchar(8) null,
    PRIMARY KEY (id_entidad)
);

-- UNIDAD: Unidad de la entidad remitente o destinataria
CREATE TABLE unidad (
    id_unidad serial not null,
    id_entidad integer not null,
    nombre text not null,
    telefono varchar(8) null,
    PRIMARY KEY (id_unidad),
    FOREIGN KEY (id_entidad) REFERENCES entidad (id_entidad)
);

-- TIPO DE DOCUMENTO: Los diferentes tipos de documentos que se recibiran (carta, memo, informe, etc.).
CREATE TABLE tipo_documento (
    id_tipo_doc serial not null,
    nombre text not null,
    descripcion text null,
    PRIMARY KEY (id_tipo_doc)
);

-- CORRESPONDENCIA: Datos de la correspondecia (remitente, asunto, destinatario/s, tipo de correspondecia, etc.)
CREATE TABLE correspondecia (
    id_correspondencia serial not null,
    id_usuario integer not null,
    id_tipo_doc integer not null,
    remitente integer not null,
    asunto text not null,
    interna boolean not null default false,
    PRIMARY KEY (id_correspondencia),
    FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario),
    FOREIGN KEY (id_tipo_doc) REFERENCES tipo_documento (id_tipo_doc),
    FOREIGN KEY (remitente) REFERENCES persona (id_persona)
);

-- DESTINATARIOS: Persona/s a quien esta dirigida la correspondecia
CREATE TABLE destinatario (
    id_destinatario serial not null,
    id_correspondencia integer not null,
    id_persona integer not null,
    id_entidad integer null,
    id_unidad integer null,
    PRIMARY KEY (id_unidad),
    FOREIGN KEY (id_correspondencia) REFERENCES correspondecia (id_correspondencia),
    FOREIGN KEY (id_persona) REFERENCES persona (id_persona),
    FOREIGN KEY (id_entidad) REFERENCES entidad (id_entidad),
    FOREIGN KEY (id_unidad) REFERENCES unidad (id_unidad)
);

-- ESTADO: Los diferentes estados que tendra la correspondecia (Registrada, recibida, entregada, enviada, archivada)
CREATE TABLE estado (
    id_estado serial not null,
    nombre text not null,
    descripcion text null,
    PRIMARY KEY (id_estado)
);

-- ESTADO CORRESPONDENCIA: Datos de la recepcion/envio/actualizacion de estado de la correspondecia (Quien recibe/envia/cambia el estado, fecha, etc.)
CREATE TABLE estado_correspondencia (
    id_estado_correspondencia serial not null,
    id_correspondencia integer not null,
    id_usuario integer not null,
    id_estado integer not null,
    fecha timestamp not null default localtimestamp(0),
    PRIMARY KEY (id_estado_correspondencia),
    FOREIGN KEY (id_correspondencia) REFERENCES correspondecia (id_correspondencia),
    FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario),
    FOREIGN KEY (id_estado) REFERENCES estado (id_estado)
);

-- OBSERVACIONES: Observaciones que se puedan hacer a la correspondecia en cada estado que tome
CREATE TABLE observacion (
    id_observacion serial not null,
    id_estado_correspondencia integer not null,
    contenido text not null,
    PRIMARY KEY (id_observacion),
    FOREIGN KEY (id_estado_correspondencia) REFERENCES estado_correspondencia (id_estado_correspondencia)
);