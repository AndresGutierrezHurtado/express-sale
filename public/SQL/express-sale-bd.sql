DROP DATABASE IF EXISTS `express-sale-bd`;
CREATE DATABASE `express-sale-bd`;
USE `express-sale-bd`;


DROP TABLE IF EXISTS `usuarios`, `recuperacion_cuentas`, `trabajadores`, `roles`, `productos`, `categorias`, `calificaciones`, `calificaciones_usuarios`, `calificaciones_productos`, `multimedias`, `pedidos`, `detalles_pagos`, `detalles_envios`, `productos_pedidos`;

-- ---------------------------------------------------------------
--
-- Tabla de recuperación de contraseñas
CREATE TABLE `recuperacion_cuentas` (
    `recuperacion_id` INT PRIMARY KEY AUTO_INCREMENT,
    `usuario_id` INT NOT NULL,
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
-- Tabla de Usuarios
CREATE TABLE `usuarios` (
    `usuario_id` INT PRIMARY KEY AUTO_INCREMENT,
    `usuario_nombre` VARCHAR(100) NOT NULL,
    `usuario_apellido` VARCHAR(100) NOT NULL,
    `usuario_correo` VARCHAR(255) UNIQUE NOT NULL,
    `usuario_alias` VARCHAR(50) UNIQUE NOT NULL,
    `usuario_telefono` DECIMAL(10, 0) UNIQUE,
    `usuario_direccion` TEXT,
    `usuario_contra` TEXT NOT NULL,
    `usuario_creacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `usuario_actualizacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `usuario_imagen_url` VARCHAR(255) DEFAULT '/public/images/users/default.jpg',
    `rol_id` INT DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `usuarios` (`usuario_id`, `usuario_nombre`, `usuario_apellido`, `usuario_correo`, `usuario_alias`, `usuario_telefono`, `usuario_direccion`, `usuario_contra`, `usuario_creacion`, `usuario_actualizacion`, `usuario_imagen_url`, `rol_id`) VALUES
-- Clientes
(1, 'Express', 'Sale', 'expresssale.exsl@gmail.com', 'Express_Sale', NULL, NULL, '81dc9bdb52d04dc20036dbd8313ed055', '2024-07-25 09:39:15', '2024-07-25 09:56:12', '/public/images/users/1.jpg', 4),
-- Vendedores
(2, 'Andrés', 'Gutiérrez Hurtado', 'andres52885241@gmail.com', 'Andres_Gutierrez', 3209202177, 'Dg. 68D Sur #70c-31, Bogotá, Colombia', '81dc9bdb52d04dc20036dbd8313ed055', '2024-07-25 09:47:10', '2024-07-25 09:47:10', '/public/images/users/2.jpg', 2),
(3, 'David Fernando', 'Diaz Niausa', 'davidfernandodiazniausa@gmail.com', 'David_Diaz', 3214109557, 'Cra. 5i Este #89-23, Bogotá, Colombia', '81dc9bdb52d04dc20036dbd8313ed055', '2024-07-25 09:53:27', '2024-07-25 09:53:27', '/public/images/users/default.jpg', 2),
(4, 'Jaider Harley', 'Rondon Herrera', 'rondonjaider@gmail.com', 'Jaider_Rondon', 3112369205, 'Cra. 5i Este #89-23, Bogotá, Colombia', '81dc9bdb52d04dc20036dbd8313ed055', '2024-07-25 09:54:25', '2024-07-25 09:54:25', '/public/images/users/default.jpg', 2),
(5, 'Juan Sebastian', 'Bernal Gamboa', 'juansebastianbernalgamboa@gmail.com', 'Juan_Bernal', 3053964455, 'Cra. 5i Este #89-23, Bogotá, Colombia', '81dc9bdb52d04dc20036dbd8313ed055', '2024-07-25 09:55:02', '2024-07-25 09:55:02', '/public/images/users/default.jpg', 2),
-- Domiciliarios
(6, 'Samuel', 'Useche Chaparro', 'samuuseche01@gmail.com', 'Samuel_Useche', 3107838443, 'Cl. 68f Sur #71g-18, Bogotá, Colombia', '81dc9bdb52d04dc20036dbd8313ed055', '2024-07-25 10:05:19', '2024-07-25 10:05:19', '/public/images/users/default.jpg', 3),
-- Clientes
(7, 'Kevin Alejandro', 'Parra Cifuentes', 'luisparra5380@gmail.com', 'Kevin_Parra', 3212376552, 'Cra. 19b #62a Sur, Bogotá, Colombia', '81dc9bdb52d04dc20036dbd8313ed055', '2024-07-25 10:04:47', '2024-07-25 10:04:47', '/public/images/users/default.jpg', 1),
(8, 'Luna Sofía', 'Pinzón Bejarano', 'lunasofiapinzonbejarano2@gmail.com', 'Luna_Pinzon', 3027447950, 'Cl. 65 Sur #78h-65 a 78h-39', '81dc9bdb52d04dc20036dbd8313ed055', '2024-07-25 10:14:00', '2024-09-30 14:51:42', '/public/images/users/default.jpg', 1),
(9, 'Yenner Sneider', 'Alayon Benavides', 'yalayon@gmail.com', 'Yenner_Alayon', 3112006677, 'Cra. 53 #25 Sur # 47, Bogotá', '81dc9bdb52d04dc20036dbd8313ed055', '2024-07-25 10:11:00', '2024-09-30 14:48:52', '/public/images/users/default.jpg', 1),
(10, 'Wendy Alejandra', 'Navarro Arias', 'nwendy798@gmail.com', 'Wendy_Navarro', 3044462452, 'Dg. 69 Sur #68-20, Bogotá, Colombia', '81dc9bdb52d04dc20036dbd8313ed055', '2024-07-25 10:10:00', '2024-09-30 14:47:52', '/public/images/users/default.jpg', 1),
(11, 'Daniel Josue', 'Peña Puentes', 'daniel.pena@gmail.com', 'Daniel_Pena', 3204978642, 'Cra. 22f #58c Sur-1 a 58c Sur-15', '81dc9bdb52d04dc20036dbd8313ed055', '2024-07-25 10:12:00', '2024-09-30 14:46:39', '/public/images/users/default.jpg', 1),
(12, 'Luis Alejandro', 'Saenz León', 'luis.saenz@gmail.com', 'Luis_Saenz', 3134431827, 'Cra. 31 #68d Sur-1 a 68d Sur-85', '81dc9bdb52d04dc20036dbd8313ed055', '2024-07-25 10:13:00', '2024-09-30 14:47:16', '/public/images/users/default.jpg', 1),
(13, 'Vladimir', 'Cortes Arevalo', 'vcortes@gmail.com', 'Vladimir_Cortes', NULL, NULL, '81dc9bdb52d04dc20036dbd8313ed055', '2024-07-25 10:15:00', '2024-07-25 10:15:00', '/public/images/users/default.jpg', 1);

-- ---------------------------------------------------------------
--
-- Tabla de Trabajadores
CREATE TABLE `trabajadores` (
    `trabajador_id` INT PRIMARY KEY AUTO_INCREMENT,
    `trabajador_descripcion` TEXT NOT NULL DEFAULT 'usuario nuevo.',
    `trabajador_numero_trabajos` INT NOT NULL DEFAULT 0,
    `trabajador_saldo` DECIMAL(10, 0) NOT NULL DEFAULT 0,
    `usuario_id` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `trabajadores` (`usuario_id`) VALUES
(2), -- Andrés Gutiérrez
(3), -- David Diaz
(4), -- Jaider Herrera
(5), -- Juan Bernal
(6); -- Samuel Useche

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
-- Tabla de Productos
CREATE TABLE `productos` (
    `producto_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `producto_nombre` VARCHAR(255) NOT NULL,
    `producto_descripcion` TEXT NOT NULL,
    `producto_cantidad` INT NOT NULL,
    `producto_precio` DECIMAL(10, 0) NOT NULL,
    `producto_imagen_url` VARCHAR(255) NOT NULL DEFAULT '/public/images/products/default.jpg',
    `producto_estado` ENUM('privado', 'publico') NOT NULL DEFAULT 'publico',
    `producto_fecha` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `usuario_id` INT NOT NULL,
    `categoria_id` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar datos en la tabla productos
INSERT INTO `productos` (`producto_id`, `producto_nombre`, `producto_descripcion`, `producto_cantidad`, `producto_precio`, `producto_imagen_url`, `producto_estado`, `producto_fecha`, `usuario_id`, `categoria_id`) VALUES
-- Moda
(1, 'Nike Air Jordan 1', 'Las icónicas zapatillas Nike Air Jordan 1 son un clásico atemporal en el mundo de la moda urbana, conocidas por su estilo y comodidad.', 15, 289900, '/public/images/products/1.jpg', 'publico', '2024-02-01 05:00:00', 3, 1),
(2, 'Cadena Cubana de Plata', 'Una cadena cubana de plata es un accesorio clásico y llamativo que puede complementar cualquier atuendo, ya sea casual o más elegante.', 9, 24900, '/public/images/products/2.jpg', 'publico', '2024-03-25 05:00:00', 3, 1),
(3, 'Casio G-Shock GA-2100', 'El reloj Casio G-Shock GA-2100 es conocido por su resistencia y estilo, con características como resistencia a golpes, al agua y un diseño moderno y elegante.', 10, 224000, '/public/images/products/3.jpg', 'publico', '2024-04-20 05:00:00', 3, 1),
-- Tecnología
(4, 'iPhone 13 Pro', 'El iPhone 13 Pro es el último modelo de Apple que combina un diseño elegante con un rendimiento potente y cámaras avanzadas para capturar imágenes impresionantes.', 8, 2100000, '/public/images/products/4.jpg', 'publico', '2024-05-10 05:00:00', 4, 3),
(5, 'Xbox Series X', 'La Xbox Series X ofrece potencia de próxima generación, velocidades de carga ultrarrápidas y una amplia biblioteca de juegos para una experiencia de juego inigualable.', 13, 3599900, '/public/images/products/5.jpg', 'publico', '2024-05-05 05:00:00', 4, 3),
(6, 'PlayStation 5', 'La PlayStation 5 es la consola de última generación de Sony, que ofrece gráficos impresionantes, carga ultrarrápida y una amplia variedad de juegos exclusivos.', 12, 4599900, '/public/images/products/6.jpg', 'publico', '2024-04-15 05:00:00', 4, 3),
-- Comida
(7, 'Galletas Oreo', 'Las deliciosas galletas Oreo, con su crujiente galleta y su cremoso relleno de vainilla, son un clásico de la merienda que gusta a niños y adultos por igual.', 40, 26900, '/public/images/products/7.jpg', 'publico', '2024-03-01 05:00:00', 5, 2),
(8, 'Nutella', 'La crema de avellanas Nutella, con su textura suave y su sabor dulce, es un imprescindible en el desayuno de millones de personas en todo el mundo.', 22, 7000, '/public/images/products/8.jpg', 'publico', '2024-02-10 05:00:00', 5, 2),
(9, 'KitKat', 'El delicioso chocolate KitKat, con sus característicos barquillos y su irresistible sabor, es el snack perfecto para disfrutar en cualquier momento del día.', 28, 4000, '/public/images/products/9.jpg', 'publico', '2024-03-20 05:00:00', 5, 2),
-- Otros
(10, 'Mancuernas Ajustables', 'Un par de mancuernas ajustables con diferentes pesos, perfectas para entrenamiento de fuerza en casa o en el gimnasio.', 8, 89900, '/public/images/products/10.jpg', 'publico', '2024-04-05 05:00:00', 2, 4),
(11, 'Megaplex | Creatine Power', 'Suplemento de proteína en polvo de alta calidad, ideal para la recuperación muscular y el crecimiento después del entrenamiento.', 10, 59900, '/public/images/products/11.jpg', 'publico', '2024-05-01 05:00:00', 2, 4),
(12, 'Rubik`s Cube', 'El clásico cubo de Rubik, con su diseño de colores vivos y su desafiante mecánica, es uno de los rompecabezas más populares y reconocidos del mundo.', 15, 15000, '/public/images/products/12.jpg', 'publico', '2024-02-15 05:00:00', 2, 4);

-- ---------------------------------------------------------------
--
-- Tabla de Calificaciones
CREATE TABLE `calificaciones` (
    `calificacion_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `calificacion_comentario` TEXT NOT NULL,
    `calificacion_imagen_url` VARCHAR(255) NOT NULL,
    `calificacion_fecha` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `calificacion` INT NOT NULL,
    `usuario_id` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `calificaciones` (`calificacion_id`, `calificacion_comentario`, `calificacion_imagen_url`, `calificacion_fecha`, `calificacion`, `usuario_id`) VALUES
-- Kevin Parra
(1, 'Excelente producto, llegó en condiciones impecables. Estoy muy satisfecho con mi compra.', '/public/images/califications/1.jpg', '2024-02-15 10:30:00', 5, 7),
(2, 'El vendedor fue muy amable y cumplió con lo prometido. Totalmente recomendable.', '', '2024-03-05 11:00:00', 5, 7),
(3, 'Recibí el producto vencido y la atención al cliente fue muy deficiente. No estoy contento con esta experiencia.', '', '2024-04-12 14:15:00', 1, 7),
-- Luna Pinzon
(4, '¡Simplemente me encanta este producto! Ha superado mis expectativas.', '', '2024-05-20 09:20:00', 5, 8),
(5, 'Esta proteína me ha sido de gran ayuda. La recomiendo sin dudar.', '', '2024-06-25 13:45:00', 4, 8),
(6, 'Muy buen vendedor, estoy contenta con mi compra.', '', '2024-07-30 17:30:00', 5, 8),
-- Yenner Alayon
(7, 'Lamentablemente, no me gustó el producto. No lo volvería a comprar.', '', '2024-08-15 08:00:00', 1, 9),
(8, 'La calidad del producto ha sido buena hasta ahora. Estoy satisfecho.', '', '2024-08-20 12:30:00', 4, 9),
(9, 'El vendedor no cumplió con los plazos de entrega. Eso fue decepcionante.', '', '2024-09-01 15:15:00', 2, 9),
-- Wendy Navarro
(10, 'Estoy encantada con este producto. Sin duda lo volvería a comprar.', '', '2024-09-10 10:10:00', 5, 10),
(11, 'El cubo me ha proporcionado mucha diversión. Estoy feliz con la compra.', '', '2024-09-15 14:00:00', 4, 10),
(12, 'Buen vendedor. La entrega fue rápida y sin problemas.', '', '2024-09-20 16:45:00', 5, 10),
-- Daniel Peña
(13, 'El producto no llegó tan bien como esperaba. No se ve igual que en la imagen.', '', '2024-09-25 09:30:00', 3, 11),
(14, 'La experiencia con el vendedor no fue la mejor. Podría mejorar.', '', '2024-09-27 11:00:00', 2, 11),
(15, 'El vendedor no cumplió con los tiempos de entrega, lo cual fue decepcionante.', '', '2024-09-28 15:00:00', 2, 11),
-- Luis Saenz
(16, 'Estos zapatos son excelentes y a buen precio. Estoy muy contento.', '', '2024-09-29 13:30:00', 5, 12),
(17, 'El vendedor cumple perfectamente con su rol. Excelente servicio.', '', '2024-09-29 14:00:00', 5, 12),
(18, 'No me impresionó el vendedor. Debería ser más profesional.', '', '2024-09-29 15:00:00', 3, 12),
-- Vladimir Cortes
(19, 'Me encantó el producto. Es justo lo que buscaba.', '', '2024-09-29 16:00:00', 5, 13),
(20, 'El vendedor no estuvo a la altura. Necesita mejorar su atención.', '', '2024-09-29 16:30:00', 2, 13),
(21, 'El vendedor tiene que esforzarse más. No estoy satisfecho con la experiencia.', '', '2024-09-30 17:00:00', 2, 13);


-- ---------------------------------------------------------------
--
-- Tabla de Relación Calificaciones y Usuarios
CREATE TABLE `calificaciones_usuarios` (
    `calificacion_id` INT NOT NULL,
    `usuario_id` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `calificaciones_usuarios` (`calificacion_id`, `usuario_id`) VALUES
(2, 2),
(6, 2),
(9, 3),
(12, 3),
(14, 4),
(15, 4),
(17, 5),
(18, 5),
(20, 2),
(21, 3);

-- ---------------------------------------------------------------
--
-- Tabla de Relación Calificaciones y Productos
CREATE TABLE `calificaciones_productos` (
    `calificacion_id` INT NOT NULL,
    `producto_id` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `calificaciones_productos` (`calificacion_id`, `producto_id`) VALUES
(1, 1),
(3, 3),
(4, 10),
(5, 5),
(7, 4),
(8, 7),
(10, 3),
(11, 7),
(13, 10),
(16, 3),
(19, 10);

-- ---------------------------------------------------------------
--
-- Tabla de archivos multimedia
CREATE TABLE `multimedias` (
    `multimedia_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `multimedia_url` VARCHAR(255) NOT NULL,
    `multimedia_tipo` ENUM('imagen', 'video') NOT NULL,
    `producto_id` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `multimedias` (`multimedia_url`, `multimedia_tipo`, `producto_id`) VALUES
('/public/images/products/media/1_0.20240728012919.jpg', 'imagen', 1),
('/public/images/products/media/1_1.20240728012919.mp4', 'video', 1),
('/public/images/products/media/1_2.20240728012919.jpg', 'imagen', 1);

-- ---------------------------------------------------------------
--
-- Tabla de Pedidos
CREATE TABLE `pedidos` (
    `pedido_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `usuario_id` INT NOT NULL,
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
    `producto_id` INT NOT NULL,
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
