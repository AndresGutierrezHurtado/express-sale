DROP DATABASE IF EXISTS `express-sale-bd`;
CREATE DATABASE `express-sale-bd`;
USE `express-sale-bd`;


DROP TABLE IF EXISTS `usuarios`, `recuperacion_cuentas`, `trabajadores`, `roles`, `productos`, `categorias`, `calificaciones`, `calificaciones_usuarios`, `calificaciones_productos`, `multimedias`, `pedidos`, `detalles_pagos`, `detalles_envios`, `productos_pedidos`;

-- ---------------------------------------------------------------
--
-- Tabla de recuperación de contraseñas
CREATE TABLE `recuperacion_cuentas` (
    `recuperacion_id` INT PRIMARY KEY AUTO_INCREMENT,
    `usuario_id` VARCHAR(60) NOT NULL,
    `token` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `fecha_creacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `fecha_expiracion` TIMESTAMP DEFAULT DATE_ADD(CURRENT_TIMESTAMP, INTERVAL 1 HOUR)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
    `usuario_imagen_url` VARCHAR(255) DEFAULT '/images/users/default.jpg',
    `rol_id` INT DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `usuarios` (`usuario_id`, `usuario_nombre`, `usuario_apellido`, `usuario_correo`, `usuario_alias`, `usuario_telefono`, `usuario_direccion`, `usuario_contra`, `usuario_creacion`, `usuario_actualizacion`, `usuario_imagen_url`, `rol_id`) VALUES
('0c0c2f13-dc1b-441a-9d63-29ff2ee0e28b', 'Kevin Alejandro', 'Parra Cifuentes', 'luisparra5380@gmail.com', 'Kevin_Parra', NULL, NULL, '$2b$10$jTgbEuDRXCmyufG.P1tp0.GHXCMdpfjFKmLpi0xWX/tGYROxel9J2', '2024-10-09 19:39:04', '2024-10-09 19:39:04', '/images/users/default.jpg', 1),
('0f942718-af96-4474-82e2-62f3c92ff321', 'Express', 'Sale', 'expresssale.exsl@gmail.com', 'Express_Sale', NULL, NULL, '$2b$10$fmyU.b4VO/eFhr6MKyuUhOj3lkFGg1fG7BE4rwzBQzz8uWHrGneny', '2024-10-09 19:38:21', '2024-10-09 19:38:21', '/images/users/0f942718-af96-4474-82e2-62f3c92ff321.jpg', 4),
('83c44447-d4fc-46e4-a8e1-5b4c0c1aa44d', 'Juan Sebastian', 'Bernal Gamboa', 'juansebastianbernalgamboa@gmail.com', 'Juan_Bernal', NULL, NULL, '$2b$10$zh/hKBWs9Po45VleG.oosuq3rjly0iYimojTK9VujVfLDsZ9qxsB6', '2024-10-09 19:38:57', '2024-10-09 19:38:57', '/images/users/83c44447-d4fc-46e4-a8e1-5b4c0c1aa44d.jpg', 2),
('971426df-a3b5-45d4-98b7-e24b7ac5e2de', 'Wendy Alejandra', 'Navarro Arias', 'nwendy798@gmail.com', 'Wendy_Navarro', NULL, NULL, '$2b$10$NQZHjhQ4IgqJJgmY8TB3guqCI3Moi160CkdMEX6Tu0tpJ7PuPQ1gO', '2024-10-09 19:41:00', '2024-10-09 19:41:00', '/images/users/default.jpg', 1),
('98a6ce1f-550f-4f70-8756-0031a950d848', 'Andrés', 'Gutiérrez Hurtado', 'andres52885241@gmail.com', 'Andres_Gutierrez', NULL, NULL, '$2b$10$0uRWEFjgKkeDTewwC1lx..ujMZQK0N3nHeQnyTB0.0B7w9jxGzOEG', '2024-10-09 19:38:42', '2024-10-09 19:38:42', '/images/users/98a6ce1f-550f-4f70-8756-0031a950d848.jpg', 2),
('99dee5c0-58cc-4ddc-82f7-3c7deff24acc', 'Luna Sofia', 'Pinzon Bejarano', 'lunasofiapinzonbejarano@gmail.com', 'Luna_Pinzon', NULL, NULL, '$2b$10$yCgOdXZHX.xIYQG4AJHA9exrZnshhqLPNtDzqClnDqYNnGLHBSpZK', '2024-10-09 19:41:35', '2024-10-09 19:41:35', '/images/users/default.jpg', 1),
('adb0552e-0299-4690-a321-370c6cfe9779', 'David Fernando', 'Diaz Niausa', 'davidfernandodiazniausa@gmail.com', 'David_Diaz', NULL, NULL, '$2b$10$8mITiuC7w4AdY/9wd/GdD.YFhIi0fMFWSZNQI9S3jfntU/3udx4Iu', '2024-10-09 19:38:46', '2024-10-09 19:38:46', '/images/users/adb0552e-0299-4690-a321-370c6cfe9779.jpg', 2),
('d40fc373-15ed-44c8-8a4e-172743226503', 'Jaider Harley', 'Rondon Herrera', 'rondonjaider@gmail.com', 'Jaider_Rondon', NULL, NULL, '$2b$10$04lNySsMLXGcaIalJRzP3OVMoI85KPnRjc41KhmnUM8Sws3IjvbRq', '2024-10-09 19:38:51', '2024-10-09 19:38:51', '/images/users/d40fc373-15ed-44c8-8a4e-172743226503.jpg', 2),
('e56759f4-e104-43eb-a14a-38a1d15b17b0', 'Samuel', 'Useche Chaparro', 'samuuseche01@gmail.com', 'Samuel_Useche', NULL, NULL, '$2b$10$gqb2UBPtDN3tSzGeTI8tJ.K.5OeklkCPV3NVjgol5/ZSucALD.pBe', '2024-10-09 19:39:11', '2024-10-09 19:39:11', '/images/users/default.jpg', 3);

-- ---------------------------------------------------------------
--
-- Tabla de Trabajadores
CREATE TABLE `trabajadores` (
    `trabajador_id` INT PRIMARY KEY AUTO_INCREMENT,
    `trabajador_descripcion` TEXT NOT NULL DEFAULT 'usuario nuevo.',
    `trabajador_numero_trabajos` INT NOT NULL DEFAULT 0,
    `trabajador_saldo` DECIMAL(10, 0) NOT NULL DEFAULT 0,
    `usuario_id` VARCHAR(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `trabajadores` (`trabajador_id`, `trabajador_descripcion`, `trabajador_numero_trabajos`, `trabajador_saldo`, `usuario_id`) VALUES
(1, 'usuario nuevo.', 0, 0, '98a6ce1f-550f-4f70-8756-0031a950d848'), -- Andres Gutierrez
(2, 'usuario nuevo.', 0, 0, 'adb0552e-0299-4690-a321-370c6cfe9779'), -- David Fernando Diaz
(3, 'usuario nuevo.', 0, 0, 'd40fc373-15ed-44c8-8a4e-172743226503'), -- Jaider Harley
(4, 'usuario nuevo.', 0, 0, '83c44447-d4fc-46e4-a8e1-5b4c0c1aa44d'), -- Juan Sebastian
(5, 'usuario nuevo.', 0, 0, 'e56759f4-e104-43eb-a14a-38a1d15b17b0'); -- Samuel Useche

-- ---------------------------------------------------------------
--
-- Tabla de retiros
CREATE TABLE `retiros` (
    `retiro_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `trabajador_id` INT NOT NULL,
    `retiro_valor` DECIMAL(10, 2) NOT NULL,
    `retiro_fecha` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
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
-- Tabla de Productos
CREATE TABLE `productos` (
    `producto_id` VARCHAR(60) NOT NULL PRIMARY KEY,
    `producto_nombre` VARCHAR(255) NOT NULL,
    `producto_descripcion` TEXT NOT NULL,
    `producto_cantidad` INT NOT NULL,
    `producto_precio` DECIMAL(10, 0) NOT NULL,
    `producto_imagen_url` VARCHAR(255) NOT NULL DEFAULT '/images/products/default.jpg',
    `producto_estado` ENUM('privado', 'publico') NOT NULL DEFAULT 'publico',
    `producto_fecha` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `usuario_id` VARCHAR(60) NOT NULL,
    `categoria_id` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `productos` (`producto_id`, `producto_nombre`, `producto_descripcion`, `producto_cantidad`, `producto_precio`, `producto_imagen_url`, `producto_estado`, `producto_fecha`, `usuario_id`, `categoria_id`) VALUES
('26b93a99-6158-4887-89a6-fb9b2c66adb3', 'Galletas Oreo', 'Las deliciosas galletas Oreo, con su crujiente galleta y su cremoso relleno de vainilla, son un clásico de la merienda que gusta a niños y adultos por igual.', 40, 26900, '/images/products/default.jpg', 'publico', '2024-10-10 21:50:00', '83c44447-d4fc-46e4-a8e1-5b4c0c1aa44d', 2),
('30771db0-257f-4989-ab46-432eb0cabda1', 'Xbox Series X', 'La Xbox Series X ofrece potencia de próxima generación, velocidades de carga ultrarrápidas y una amplia biblioteca de juegos para una experiencia de juego inigualable.', 13, 3599900, '/images/products/default.jpg', 'publico', '2024-10-10 21:49:47', 'd40fc373-15ed-44c8-8a4e-172743226503', 3),
('8cd437aa-44b3-4dd0-9a7c-fbe9502e8cc7', 'Nutella', 'La crema de avellanas Nutella, con su textura suave y su sabor dulce, es un imprescindible en el desayuno de millones de personas en todo el mundo.', 22, 7000, '/images/products/default.jpg', 'publico', '2024-10-10 21:50:04', '83c44447-d4fc-46e4-a8e1-5b4c0c1aa44d', 2),
('9380bba6-a1e6-4425-8d3a-406987b802b0', 'Rubik`s Cube', 'El clásico cubo de Rubik, con su diseño de colores vivos y su desafiante mecánica, es uno de los rompecabezas más populares y reconocidos del mundo.', 15, 15000, '/images/products/default.jpg', 'publico', '2024-10-10 21:50:32', '98a6ce1f-550f-4f70-8756-0031a950d848', 4),
('acf7e031-5d1f-48cf-98e0-f6c770d03c44', 'Megaplex | Creatine Power', 'Suplemento de proteína en polvo de alta calidad, ideal para la recuperación muscular y el crecimiento después del entrenamiento.', 10, 59900, '/images/products/default.jpg', 'publico', '2024-10-10 21:50:19', '98a6ce1f-550f-4f70-8756-0031a950d848', 4),
('b8f7eea2-2a9e-4714-80bf-9d8fd1c9434c', 'KitKat', 'El delicioso chocolate KitKat, con sus característicos barquillos y su irresistible sabor, es el snack perfecto para disfrutar en cualquier momento del día.', 28, 4000, '/images/products/default.jpg', 'publico', '2024-10-10 21:50:09', '83c44447-d4fc-46e4-a8e1-5b4c0c1aa44d', 2),
('d22cf268-45aa-49db-8f50-e3ce1b0ac95b', 'Nike Air Jordan 1', 'Las icónicas zapatillas Nike Air Jordan 1 son un clásico atemporal en el mundo de la moda urbana, conocidas por su estilo y comodidad.', 15, 289900, '/images/products/default.jpg', 'publico', '2024-10-10 21:49:11', 'adb0552e-0299-4690-a321-370c6cfe9779', 1),
('e11ebbcf-41ab-4bf2-9f58-6e5474259beb', 'Casio G-Shock GA-2100', 'El reloj Casio G-Shock GA-2100 es conocido por su resistencia y estilo, con características como resistencia a golpes, al agua y un diseño moderno y elegante.', 10, 224000, '/images/products/default.jpg', 'publico', '2024-10-10 21:49:24', 'adb0552e-0299-4690-a321-370c6cfe9779', 1),
('e1d0c3d2-5033-4466-be89-1fa8ea6ece9c', 'PlayStation 5', 'La PlayStation 5 es la consola de última generación de Sony, que ofrece gráficos impresionantes, carga ultrarrápida y una amplia variedad de juegos exclusivos.', 12, 4599900, '/images/products/default.jpg', 'publico', '2024-10-10 21:49:52', 'd40fc373-15ed-44c8-8a4e-172743226503', 3),
('efd069de-c549-4e8e-98c2-974a9b35c490', 'Cadena Cubana de Plata', 'Una cadena cubana de plata es un accesorio clásico y llamativo que puede complementar cualquier atuendo, ya sea casual o más elegante.', 9, 24900, '/images/products/default.jpg', 'publico', '2024-10-10 21:49:18', 'adb0552e-0299-4690-a321-370c6cfe9779', 1),
('f47f236b-7d84-41b9-8008-5f3287fb4e03', 'Mancuernas Ajustables', 'Un par de mancuernas ajustables con diferentes pesos, perfectas para entrenamiento de fuerza en casa o en el gimnasio.', 8, 89900, '/images/products/default.jpg', 'publico', '2024-10-10 21:50:13', '98a6ce1f-550f-4f70-8756-0031a950d848', 4),
('fe99280b-b5e3-4190-b4b2-2d4bb82ae192', 'iPhone 13 Pro', 'El iPhone 13 Pro es el último modelo de Apple que combina un diseño elegante con un rendimiento potente y cámaras avanzadas para capturar imágenes impresionantes.', 8, 2100000, '/images/products/default.jpg', 'publico', '2024-10-10 21:49:28', 'd40fc373-15ed-44c8-8a4e-172743226503', 3);

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
-- Tabla de Calificaciones
CREATE TABLE `calificaciones` (
    `calificacion_id` VARCHAR(60) NOT NULL PRIMARY KEY,
    `calificacion_comentario` TEXT NOT NULL,
    `calificacion_imagen_url` VARCHAR(255),
    `calificacion_fecha` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `calificacion` INT NOT NULL,
    `usuario_id` VARCHAR(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- ---------------------------------------------------------------
--
-- Tabla de archivos multimedia
CREATE TABLE `multimedias` (
    `multimedia_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `multimedia_url` VARCHAR(255) NOT NULL,
    `multimedia_tipo` ENUM('imagen', 'video') NOT NULL,
    `producto_id` VARCHAR(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------
--
-- Tabla de Pedidos
CREATE TABLE `pedidos` (
    `pedido_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `usuario_id` VARCHAR(60) NOT NULL,
    `pedido_fecha` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `pedido_estado` ENUM('pendiente', 'enviando', 'entregado', 'recibido') NOT NULL DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------
--
-- Tabla de Detalles de Pagos
CREATE TABLE `detalles_pagos` (
    `pago_id` INT PRIMARY KEY AUTO_INCREMENT,
    `pedido_id` INT NOT NULL,
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
    `envio_id` INT PRIMARY KEY AUTO_INCREMENT,
    `pedido_id` INT NOT NULL,
    `trabajador_id` INT,
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
    `pedido_id` INT NOT NULL,
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

DELIMITER $$
CREATE TRIGGER insertar_trabajador_despues_de_insertar_usuario
AFTER INSERT ON usuarios
FOR EACH ROW
BEGIN
    IF (NEW.rol_id = 2 OR NEW.rol_id = 3) THEN
        INSERT INTO trabajadores (usuario_id) VALUES (NEW.usuario_id);
    END IF;
END$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER bajar_saldo_trabajador_despues_de_insertar_retiros
AFTER INSERT ON retiros
FOR EACH ROW
BEGIN
    UPDATE trabajadores SET trabajador_saldo = trabajador_saldo - NEW.retiro_valor WHERE trabajador_id = NEW.trabajador_id;
END$$
DELIMITER ;