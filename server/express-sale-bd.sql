DROP DATABASE IF EXISTS `express-sale-bd`;
CREATE DATABASE `express-sale-bd`;
USE `express-sale-bd`;


DROP TABLE IF EXISTS `usuarios`, `recuperacion_cuentas`, `trabajadores`, `roles`, `productos`, `categorias`, `calificaciones`, `calificaciones_usuarios`, `calificaciones_productos`, `multimedias`, `pedidos`, `detalles_pagos`, `detalles_envios`, `productos_pedidos`, `sesiones`;

-- ---------------------------------------------------------------
--
-- Tabla de sesiones
CREATE TABLE `sesiones` (
  `sid` VARCHAR(36) NOT NULL,
  `expires` DATETIME DEFAULT NULL,
  `data` TEXT DEFAULT NULL,
  `createdAt` DATETIME NOT NULL,
  `updatedAt` DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ---------------------------------------------------------------
--
-- Tabla de recuperación de contraseñas
CREATE TABLE `recuperacion_cuentas` (
    `recuperacion_id` VARCHAR(60) PRIMARY KEY,
    `usuario_id` VARCHAR(60) NOT NULL,
    `token` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `fecha_creacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `fecha_expiracion` TIMESTAMP DEFAULT DATE_ADD(CURRENT_TIMESTAMP, INTERVAL 1 HOUR)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------
--
-- Tabla de Roles
CREATE TABLE `roles` (
    `rol_id` INT PRIMARY KEY AUTO_INCREMENT,
    `rol_nombre` VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `roles` (`rol_id`, `rol_nombre`) VALUES
(1, 'cliente'),
(2, 'vendedor'),
(3, 'domiciliario'),
(4, 'administrador');

-- ---------------------------------------------------------------
--
-- Tabla de Categorías
CREATE TABLE `categorias` (
    `categoria_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `categoria_nombre` VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `categorias` (`categoria_id`, `categoria_nombre`) VALUES
(1, 'moda'),
(2, 'comida'),
(3, 'tecnologia'),
(4, 'otros');

-- ---------------------------------------------------------------
--
-- Tabla de Usuarios
CREATE TABLE `usuarios` (
    `usuario_id` VARCHAR(60) PRIMARY KEY NOT NULL,
    `usuario_nombre` VARCHAR(100) NOT NULL,
    `usuario_apellido` VARCHAR(100) NOT NULL,
    `usuario_correo` VARCHAR(255) UNIQUE NOT NULL,
    `usuario_alias` VARCHAR(50) UNIQUE NOT NULL,
    `usuario_telefono` DECIMAL(10, 0),
    `usuario_direccion` TEXT,
    `usuario_contra` TEXT NOT NULL,
    `usuario_creacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `usuario_actualizacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `usuario_imagen_url` VARCHAR(255) DEFAULT '/images/default.jpg',
    `rol_id` INT DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `usuarios` (`usuario_id`, `usuario_nombre`, `usuario_apellido`, `usuario_correo`, `usuario_alias`, `usuario_telefono`, `usuario_direccion`, `usuario_contra`, `usuario_creacion`, `usuario_actualizacion`, `usuario_imagen_url`, `rol_id`) VALUES
('a30cd113-2e9a-4e8b-87f2-7cb7e27ff27f', 'Express', 'Sale', 'expresssale.exsl@gmail.com', 'Express_Sale', NULL, NULL, '$2a$10$LLVuZDAM7c5rwvuDdbqIJumcy1tIAbWCNFO4DxB6KLCYaqqQ7wbKW', '2024-01-17 09:23:43', '2024-10-31 07:17:28', 'https://res.cloudinary.com/dyuh7jesr/image/upload/v1730359052/express-sale/users/a30cd113-2e9a-4e8b-87f2-7cb7e27ff27f.jpg', 4),
('1997e4d2-fa0d-4cdd-b7a1-f970570a813e', 'Andrés', 'Gutiérrez Hurtado', 'andres52885241@gmail.com', 'Andres_Gutierrez', NULL, NULL, '$2a$10$mwjk.9LQkXn0Q/OtdB5k6uZU6Diaw07lzT.75hx9O/1bbDwwEzYIW', '2024-02-13 09:23:50', '2024-10-31 07:16:44', 'https://res.cloudinary.com/dyuh7jesr/image/upload/v1730359008/express-sale/users/1997e4d2-fa0d-4cdd-b7a1-f970570a813e.jpg', 2),
('1dc76732-83ea-4a78-afb8-e759959ee5c3', 'David Fernando', 'Diaz Niausa', 'davidfernandodiazniausa@gmail.com', 'David_Diaz', NULL, NULL, '$2a$10$aNvO8Br.5mKKqpzNAuoO4umUP0ZRB..dFtttiA3n7DObEN/x1cW/y', '2024-03-13 09:23:54', '2024-10-31 07:17:43', 'https://res.cloudinary.com/dyuh7jesr/image/upload/v1730359067/express-sale/users/1dc76732-83ea-4a78-afb8-e759959ee5c3.jpg', 2),
('b015e026-c217-4c39-962e-4d477c3640c9', 'Juan Sebastian', 'Bernal Gamboa', 'juansebastianbernalgamboa@gmail.com', 'Juan_Bernal', NULL, NULL, '$2a$10$g0iPipqxpIAsbFdHXEW3femJivexGekXSXrc2EHICLfdipOZVsP7G', '2024-04-15 09:24:02', '2024-10-31 07:18:05', 'https://res.cloudinary.com/dyuh7jesr/image/upload/v1730359088/express-sale/users/b015e026-c217-4c39-962e-4d477c3640c9.jpg', 2),
('e7864790-7e10-4af8-af5f-67b1af7cc1f6', 'Jaider Harley', 'Rondon Herrera', 'rondonjaider@gmail.com', 'Jaider_Rondon', NULL, NULL, '$2a$10$QjOD1CqPAYG/eyzzy2neneB50f78LmQqqirNg.Sv4gfTL1efYEpBO', '2024-05-05 09:23:57', '2024-10-31 07:18:17', 'https://res.cloudinary.com/dyuh7jesr/image/upload/v1730359101/express-sale/users/e7864790-7e10-4af8-af5f-67b1af7cc1f6.jpg', 2),
('2078ad6a-1373-4940-90a0-bf4bf1228e73', 'Samuel', 'Useche Chaparro', 'samuuseche01@gmail.com', 'Samuel_Useche', NULL, NULL, '$2a$10$XWDYW/hzBQuStDg4WTyUn.N2lH3VloZVx2.U4raQ.FkCfWQsmt3N.', '2024-06-13 09:24:10', '2024-05-02 09:24:10', '/images/default.jpg', 3),
('764ca4c3-b387-4be5-ab11-8d39db2e99af', 'Kevin Alejandro', 'Parra Cifuentes', 'luisparra5380@gmail.com', 'Kevin_Parra', NULL, NULL, '$2a$10$wRvGOuETCvUYQvJx9K/2t.LwY4DG6/l5SE6UX7vTDQavIvahS1EO6', '2024-07-14 09:24:19', '2024-10-13 09:24:19', '/images/default.jpg', 1),
('0cb61e19-b59f-4d7e-83e6-ec4de605b3ee', 'Luna Sofia', 'Pinzon Bejarano', 'lunasofiapinzonbejarano@gmail.com', 'Luna_Pinzon', NULL, NULL, '$2a$10$kxkYAIQa/o5iJHy6Mn1C3.9jRVvnCF0UZnqJgRxL0LCy6NAJa.B7G', '2024-08-13 09:26:19', '2024-02-10 09:26:19', '/images/default.jpg', 1),
('7d7aa315-f996-4316-8af4-86fe4786ce4b', 'Wendy Alejandra', 'Navarro Arias', 'nwendy798@gmail.com', 'Wendy_Navarro', NULL, NULL, '$2a$10$z1yVOAC4MEPVxGl4WjQQmeX078Rq7eJEfE9UOyYSVLj79FlsYSBlq', '2024-09-22 09:26:37', '2024-10-13 09:26:37', '/images/default.jpg', 1);

-- ---------------------------------------------------------------
--
-- Tabla de Trabajadores
CREATE TABLE `trabajadores` (
    `trabajador_id` VARCHAR(60) PRIMARY KEY,
    `trabajador_descripcion` TEXT NOT NULL DEFAULT 'usuario nuevo.',
    `trabajador_numero_trabajos` INT NOT NULL DEFAULT 0,
    `trabajador_saldo` DECIMAL(10, 0) NOT NULL DEFAULT 0,
    `usuario_id` VARCHAR(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `trabajadores` (`trabajador_id`, `trabajador_descripcion`, `trabajador_numero_trabajos`, `trabajador_saldo`, `usuario_id`) VALUES
('3439d1be-f5ee-4a34-98e7-accec2eb1729', 'usuario nuevo.', 0, 0, '1997e4d2-fa0d-4cdd-b7a1-f970570a813e'), -- Andrés Gutiérrez
('5a5c533d-55f8-469e-b3a3-724deba8c0ad', 'usuario nuevo.', 0, 0, '1dc76732-83ea-4a78-afb8-e759959ee5c3'), -- David Fernando Diaz
('285dd857-d030-4f90-a193-5383500b0963', 'usuario nuevo.', 0, 0, 'e7864790-7e10-4af8-af5f-67b1af7cc1f6'), -- Jaider Rondon
('0b89b820-4c52-4ebd-aa4f-18262eac02db', 'usuario nuevo.', 0, 0, 'b015e026-c217-4c39-962e-4d477c3640c9'), -- Juan Bernal
('4859698d-85f6-4e33-a668-c10a7d2a5a2d', 'usuario nuevo.', 0, 0, '2078ad6a-1373-4940-90a0-bf4bf1228e73'); -- Samuel Useche

-- ---------------------------------------------------------------
--
-- Tabla de retiros
CREATE TABLE `retiros` (
    `retiro_id` VARCHAR(60) NOT NULL PRIMARY KEY,
    `trabajador_id` VARCHAR(60) NOT NULL,
    `retiro_valor` DECIMAL(10, 2) NOT NULL,
    `retiro_fecha` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------
--
-- Tabla de Productos
CREATE TABLE `productos` (
    `producto_id` VARCHAR(60) NOT NULL PRIMARY KEY,
    `producto_nombre` VARCHAR(255) NOT NULL,
    `producto_descripcion` TEXT NOT NULL,
    `producto_cantidad` INT NOT NULL,
    `producto_precio` DECIMAL(10, 0) NOT NULL,
    `producto_imagen_url` VARCHAR(255) NOT NULL DEFAULT '/images/default.jpg',
    `producto_estado` ENUM('privado', 'publico') NOT NULL DEFAULT 'publico',
    `producto_fecha` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `usuario_id` VARCHAR(60) NOT NULL,
    `categoria_id` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `productos` (`producto_id`, `producto_nombre`, `producto_descripcion`, `producto_cantidad`, `producto_precio`, `producto_imagen_url`, `producto_estado`, `producto_fecha`, `usuario_id`, `categoria_id`) VALUES
('09fd4c7b-cd37-4e6d-a7f6-ae8f93734005', 'Rubik`s Cube', 'El clásico cubo de Rubik, con su diseño de colores vivos y su desafiante mecánica, es uno de los rompecabezas más populares y reconocidos del mundo.', 15, 15000, '/images/default.jpg', 'publico', '2024-10-13 04:31:52', '1997e4d2-fa0d-4cdd-b7a1-f970570a813e', 4),
('10014419-f396-4639-925f-2b0814aa81f3', 'Nike Air Jordan 1', 'Las icónicas zapatillas Nike Air Jordan 1 son un clásico atemporal en el mundo de la moda urbana, conocidas por su estilo y comodidad.', 15, 289900, '/images/default.jpg', 'publico', '2024-10-13 04:36:21', '1dc76732-83ea-4a78-afb8-e759959ee5c3', 1),
('56a133ce-d6b7-4d63-9564-9fa656232efa', 'Megaplex | Creatine Power', 'Suplemento de proteína en polvo de alta calidad, ideal para la recuperación muscular y el crecimiento después del entrenamiento.', 10, 59900, '/images/default.jpg', 'publico', '2024-10-13 04:31:07', '1997e4d2-fa0d-4cdd-b7a1-f970570a813e', 4),
('5d34b009-ce5b-4e20-950c-9b89dc4b09ae', 'KitKat', 'El delicioso chocolate KitKat, con sus característicos barquillos y su irresistible sabor, es el snack perfecto para disfrutar en cualquier momento del día.', 28, 4000, '/images/default.jpg', 'publico', '2024-10-13 04:33:06', 'b015e026-c217-4c39-962e-4d477c3640c9', 2),
('662c229a-a176-4f98-b3e1-0b3bb60ff5e0', 'PlayStation 5', 'La PlayStation 5 es la consola de última generación de Sony, que ofrece gráficos impresionantes, carga ultrarrápida y una amplia variedad de juegos exclusivos.', 12, 4599900, '/images/default.jpg', 'publico', '2024-10-13 04:34:59', 'e7864790-7e10-4af8-af5f-67b1af7cc1f6', 3),
('8c468cdc-7cf2-4ffa-99e2-b4e8310fc715', 'Xbox Series X', 'La Xbox Series X ofrece potencia de próxima generación, velocidades de carga ultrarrápidas y una amplia biblioteca de juegos para una experiencia de juego inigualable.', 13, 3599900, '/images/default.jpg', 'publico', '2024-10-13 04:33:56', 'e7864790-7e10-4af8-af5f-67b1af7cc1f6', 3),
('a9458fa5-cc05-4a77-a1dc-9ff1378b1465', 'Casio G-Shock GA-2100', 'El reloj Casio G-Shock GA-2100 es conocido por su resistencia y estilo, con características como resistencia a golpes, al agua y un diseño moderno y elegante.', 10, 224000, '/images/default.jpg', 'publico', '2024-10-13 04:36:30', '1dc76732-83ea-4a78-afb8-e759959ee5c3', 1),
('b0beb7fb-57b5-4881-a29f-c86581dbae19', 'Mancuernas Ajustables', 'Un par de mancuernas ajustables con diferentes pesos, perfectas para entrenamiento de fuerza en casa o en el gimnasio.', 8, 89900, '/images/default.jpg', 'publico', '2024-10-13 04:31:30', '1997e4d2-fa0d-4cdd-b7a1-f970570a813e', 4),
('ddc2a91d-65b6-4316-9222-84cde0759911', 'Nutella', 'La crema de avellanas Nutella, con su textura suave y su sabor dulce, es un imprescindible en el desayuno de millones de personas en todo el mundo.', 22, 7000, '/images/default.jpg', 'publico', '2024-10-13 04:32:50', 'b015e026-c217-4c39-962e-4d477c3640c9', 2),
('e359851d-9813-463f-aff9-3a552a887134', 'Cadena Cubana de Plata', 'Una cadena cubana de plata es un accesorio clásico y llamativo que puede complementar cualquier atuendo, ya sea casual o más elegante.', 9, 31200, '/images/default.jpg', 'publico', '2024-10-13 04:36:50', '1dc76732-83ea-4a78-afb8-e759959ee5c3', 1),
('e3e3e594-5c65-433f-a4a3-94f75dd4aef9', 'Galletas Oreo', 'Las deliciosas galletas Oreo, con su crujiente galleta y su cremoso relleno de vainilla, son un clásico de la merienda que gusta a niños y adultos por igual.', 40, 26900, '/images/default.jpg', 'publico', '2024-10-13 04:32:41', 'b015e026-c217-4c39-962e-4d477c3640c9', 2),
('fba1a2fb-3e81-447e-adf5-e984682d700d', 'iPhone 13 Pro', 'El iPhone 13 Pro es el último modelo de Apple que combina un diseño elegante con un rendimiento potente y cámaras avanzadas para capturar imágenes impresionantes.', 8, 2100000, '/images/default.jpg', 'publico', '2024-10-13 04:35:12', 'e7864790-7e10-4af8-af5f-67b1af7cc1f6', 3);

-- ---------------------------------------------------------------
--
-- Tabla de Calificaciones
CREATE TABLE `calificaciones` (
    `calificacion_id` VARCHAR(60) NOT NULL PRIMARY KEY,
    `calificacion_comentario` TEXT NOT NULL,
    `calificacion_imagen_url` VARCHAR(255),
    `calificacion_fecha` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `calificacion` INT NOT NULL,
    `usuario_id` VARCHAR(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `calificaciones` (`calificacion_id`, `calificacion_comentario`, `calificacion_imagen_url`, `calificacion_fecha`, `calificacion`, `usuario_id`) VALUES
('f5a063d8-17c0-4362-b883-4fb41399fc42', 'Me pido uno de esos', '', '2024-10-13 04:41:41', 5, '0cb61e19-b59f-4d7e-83e6-ec4de605b3ee');

-- ---------------------------------------------------------------
--
-- Tabla de Relación Calificaciones y Usuarios
CREATE TABLE `calificaciones_usuarios` (
    `calificacion_id` VARCHAR(60) NOT NULL,
    `usuario_id` VARCHAR(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------
--
-- Tabla de Relación Calificaciones y Productos
CREATE TABLE `calificaciones_productos` (
    `calificacion_id` VARCHAR(60) NOT NULL,
    `producto_id` VARCHAR(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `calificaciones_productos` (`calificacion_id`, `producto_id`) VALUES
('f5a063d8-17c0-4362-b883-4fb41399fc42', '56a133ce-d6b7-4d63-9564-9fa656232efa');

-- ---------------------------------------------------------------
--
-- Tabla de archivos multimedia
CREATE TABLE `multimedias` (
    `multimedia_id` VARCHAR(60) NOT NULL PRIMARY KEY,
    `multimedia_url` VARCHAR(255) NOT NULL,
    `multimedia_tipo` ENUM('imagen', 'video') NOT NULL,
    `producto_id` VARCHAR(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------
--
-- Tabla de Pedidos
CREATE TABLE `pedidos` (
    `pedido_id` VARCHAR(60) NOT NULL PRIMARY KEY,
    `usuario_id` VARCHAR(60) NOT NULL,
    `pedido_fecha` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `pedido_estado` ENUM('pendiente', 'enviando', 'entregado', 'recibido') NOT NULL DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------
--
-- Tabla de Detalles de Pagos
CREATE TABLE `detalles_pagos` (
    `pago_id` VARCHAR(60) PRIMARY KEY,
    `pedido_id` VARCHAR(60) NOT NULL,
    `pago_metodo` INT NOT NULL, -- polPaymentMethodType
    `pago_valor` DECIMAL(10, 0) NOT NULL, -- TX_VALUE
    `comprador_nombre` VARCHAR(100), -- buyerFullName
    `comprador_correo` VARCHAR(255) NOT NULL, -- buyerEmail
    `comprador_tipo_documento` ENUM('CC', 'CE', 'TI', 'PPN', 'NIT', 'SSN', 'EIN') NOT NULL DEFAULT 'CC', -- payerDocumentType
    `comprador_numero_documento` DECIMAL(10, 0) NOT NULL, -- payerDocument
    `comprador_telefono` DECIMAL(10, 0) -- payerPhone
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------
--
-- Tabla de Detalles de Envíos
CREATE TABLE `detalles_envios` (
    `envio_id` VARCHAR(60) PRIMARY KEY,
    `pedido_id` VARCHAR(60) NOT NULL,
    `trabajador_id` VARCHAR(60),
    `envio_direccion` TEXT NOT NULL,
    `envio_coordenadas` VARCHAR(100),
    `fecha_inicio` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `fecha_entrega` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `envio_valor` DECIMAL(10, 0),
    `envio_mensaje` TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------
--
-- Tabla de Relación Productos y Pedidos
CREATE TABLE `productos_pedidos` (
    `pedido_id` VARCHAR(60) NOT NULL,
    `producto_id` VARCHAR(60) NOT NULL,
    `producto_precio` DECIMAL(10, 0) NOT NULL,
    `producto_cantidad` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------
--
-- Llaves Foráneas
ALTER TABLE `usuarios`
ADD CONSTRAINT `fk_usuarios_roles` 
FOREIGN KEY (`rol_id`) 
REFERENCES `roles`(`rol_id`)
ON UPDATE CASCADE
ON DELETE CASCADE;

ALTER TABLE `trabajadores`
ADD CONSTRAINT `fk_trabajadores_usuarios` 
FOREIGN KEY (`usuario_id`) 
REFERENCES `usuarios`(`usuario_id`)
ON UPDATE CASCADE
ON DELETE CASCADE;

ALTER TABLE `productos`
ADD CONSTRAINT `fk_productos_usuarios` 
FOREIGN KEY (`usuario_id`) 
REFERENCES `usuarios`(`usuario_id`)
ON UPDATE CASCADE
ON DELETE CASCADE,
ADD CONSTRAINT `fk_productos_categorias` 
FOREIGN KEY (`categoria_id`) 
REFERENCES `categorias`(`categoria_id`)
ON UPDATE CASCADE
ON DELETE CASCADE;

ALTER TABLE `calificaciones`
ADD CONSTRAINT `fk_calificaciones_usuarios` 
FOREIGN KEY (`usuario_id`) 
REFERENCES `usuarios`(`usuario_id`)
ON UPDATE CASCADE
ON DELETE CASCADE;

ALTER TABLE `calificaciones_usuarios`
ADD CONSTRAINT `fk_calificaciones_usuarios_calificaciones` 
FOREIGN KEY (`calificacion_id`) 
REFERENCES `calificaciones`(`calificacion_id`)
ON UPDATE CASCADE
ON DELETE CASCADE,
ADD CONSTRAINT `fk_calificaciones_usuarios_usuarios` 
FOREIGN KEY (`usuario_id`) 
REFERENCES `usuarios`(`usuario_id`)
ON UPDATE CASCADE
ON DELETE CASCADE;

ALTER TABLE `calificaciones_productos`
ADD CONSTRAINT `fk_calificaciones_productos_calificaciones` 
FOREIGN KEY (`calificacion_id`) 
REFERENCES `calificaciones`(`calificacion_id`)
ON UPDATE CASCADE
ON DELETE CASCADE,
ADD CONSTRAINT `fk_calificaciones_productos_productos` 
FOREIGN KEY (`producto_id`) 
REFERENCES `productos`(`producto_id`)
ON UPDATE CASCADE
ON DELETE CASCADE;

ALTER TABLE `multimedias`
ADD CONSTRAINT `fk_multimedia_productos` 
FOREIGN KEY (`producto_id`) 
REFERENCES `productos`(`producto_id`)
ON UPDATE CASCADE
ON DELETE CASCADE;

ALTER TABLE `pedidos`
ADD CONSTRAINT `fk_pedidos_usuarios` 
FOREIGN KEY (`usuario_id`) 
REFERENCES `usuarios`(`usuario_id`)
ON UPDATE CASCADE
ON DELETE CASCADE;

ALTER TABLE `detalles_pagos`
ADD CONSTRAINT `fk_detalles_pagos_pedidos` 
FOREIGN KEY (`pedido_id`) 
REFERENCES `pedidos`(`pedido_id`)
ON UPDATE CASCADE
ON DELETE CASCADE;

ALTER TABLE `detalles_envios`
ADD CONSTRAINT `fk_detalles_envios_pedidos` 
FOREIGN KEY (`pedido_id`) 
REFERENCES `pedidos`(`pedido_id`)
ON UPDATE CASCADE
ON DELETE CASCADE,
ADD CONSTRAINT `fk_detalles_envios_trabajadores` 
FOREIGN KEY (`trabajador_id`) 
REFERENCES `trabajadores`(`trabajador_id`)
ON UPDATE CASCADE
ON DELETE CASCADE;

ALTER TABLE `productos_pedidos`
ADD CONSTRAINT `fk_productos_pedidos_pedidos` 
FOREIGN KEY (`pedido_id`) 
REFERENCES `pedidos`(`pedido_id`)
ON UPDATE CASCADE
ON DELETE CASCADE,
ADD CONSTRAINT `fk_productos_pedidos_productos` 
FOREIGN KEY (`producto_id`) 
REFERENCES `productos`(`producto_id`)
ON UPDATE CASCADE
ON DELETE CASCADE;

ALTER TABLE `recuperacion_cuentas`
ADD CONSTRAINT `fk_recuperacion_cuentas_usuarios` 
FOREIGN KEY (`usuario_id`) 
REFERENCES `usuarios`(`usuario_id`)
ON UPDATE CASCADE
ON DELETE CASCADE;

ALTER TABLE `retiros`
ADD CONSTRAINT `fk_retiros_usuarios` 
FOREIGN KEY (`trabajador_id`) 
REFERENCES `trabajadores`(`trabajador_id`)
ON UPDATE CASCADE
ON DELETE CASCADE;
