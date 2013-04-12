-- Datos de tipo de usuario
INSERT  INTO tipo_usuario VALUES
(1000, 'Administrador', 'Administrador del sistema'),
(1001, 'Usuario', 'Encargado de administrar la correspondencia');


-- Datos de entidad
INSERT  INTO  entidad values (DEFAULT, 'Corte Suprema de Justicia', 'Palacio Judicial', '22421906');


-- Datos de unidad
INSERT  INTO  unidad values (DEFAULT, 1, 'Sala de lo Civil', '22421906');


-- Datos de los personas.
INSERT  INTO persona VALUES
(default, 'Foo', 'Bar'),
(default, 'Marisol', 'Canias'),
(default, 'Erick', 'Lopez'),
(default, 'Ovidio', 'Bonilla');


-- Datos de los usuarios.
INSERT INTO usuario VALUES (default, 1, 1000, default, 'admin', md5('clave'), true);
INSERT INTO usuario VALUES (default, 2, 1001, default, 'compras', md5('clave'), true);


-- Datos de tipos de documentos.
INSERT  INTO  tipo_documento VALUES
(DEFAULT, 'Carta', 'Carta'),
(DEFAULT, 'Memo', 'Memo'),
(DEFAULT, 'Informe', 'Informe'),
(DEFAULT, 'Solicitud', 'Solicitud'),
(DEFAULT, 'Invitacion', 'Invitacion');


-- Datos de estados de la correspondencia
INSERT INTO estado VALUES
(default, 'REGISTRADA', 'La correspondencia se ha registrado en el sistema; el estado inicial de cada correspondencia.'),
(default, 'RECIBIDA', 'La correspondencia se ha recibido.'),
(default, 'ENTREGADA', 'La correspondencia es entregada al/los destinatario/s.'),
(default, 'ENVIADA', 'Correspondencia enviada, el usuario actua como remitente.'),
(default, 'ARCHIVADA', 'Cualquiera actividad relacionada a la correspondencia se ha finalizado; es el estado final de toda correspondencia.');