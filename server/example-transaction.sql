CREATE DATABASE IF NOT EXISTS `express-sale-bd` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `express-sale-bd`;

CREATE TABLE `calificaciones` (
  `calificacion_id` varchar(60) NOT NULL,
  `calificacion_comentario` text NOT NULL,
  `calificacion_imagen_url` varchar(255) DEFAULT NULL,
  `calificacion_fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `calificacion` int(11) NOT NULL,
  `usuario_id` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `calificaciones` (`calificacion_id`, `calificacion_comentario`, `calificacion_imagen_url`, `calificacion_fecha`, `calificacion`, `usuario_id`) VALUES
('f5a063d8-17c0-4362-b883-4fb41399fc42', 'Me pido uno de esos', '', '2024-10-13 04:41:41', 5, '0cb61e19-b59f-4d7e-83e6-ec4de605b3ee');

CREATE TABLE `calificaciones_productos` (
  `calificacion_id` varchar(60) NOT NULL,
  `producto_id` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `calificaciones_productos` (`calificacion_id`, `producto_id`) VALUES
('f5a063d8-17c0-4362-b883-4fb41399fc42', '56a133ce-d6b7-4d63-9564-9fa656232efa');

CREATE TABLE `calificaciones_usuarios` (
  `calificacion_id` varchar(60) NOT NULL,
  `usuario_id` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `carritos` (
  `carrito_id` varchar(60) NOT NULL,
  `usuario_id` varchar(60) NOT NULL,
  `producto_id` varchar(60) NOT NULL,
  `producto_cantidad` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `categorias` (
  `categoria_id` int(11) NOT NULL,
  `categoria_nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `categorias` (`categoria_id`, `categoria_nombre`) VALUES
(1, 'moda'),
(2, 'comida'),
(3, 'tecnologia'),
(4, 'otros');

CREATE TABLE `detalles_envios` (
  `envio_id` varchar(60) NOT NULL,
  `pedido_id` varchar(60) NOT NULL,
  `trabajador_id` varchar(60) DEFAULT NULL,
  `envio_direccion` text NOT NULL,
  `envio_coordenadas` varchar(100) DEFAULT NULL,
  `fecha_inicio` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_entrega` timestamp NOT NULL DEFAULT current_timestamp(),
  `envio_valor` decimal(10,0) DEFAULT NULL,
  `envio_mensaje` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `detalles_envios` (`envio_id`, `pedido_id`, `trabajador_id`, `envio_direccion`, `envio_coordenadas`, `fecha_inicio`, `fecha_entrega`, `envio_valor`, `envio_mensaje`) VALUES
('7c74b1b0-c777-4db8-b3a3-96d45eb5743b', 'f306bf6e-18b8-4b46-ae38-a4fe05bdb4ec', NULL, 'Dg 68D sur 70C-31', '{\"lat\":4.5846685,\"lng\":-74.1612393}', '2024-11-19 12:33:30', '2024-11-19 12:33:30', 7500, 'Condominios del ensueño 1, apto 104, torre 14.');

CREATE TABLE `detalles_pagos` (
  `pago_id` varchar(60) NOT NULL,
  `pedido_id` varchar(60) NOT NULL,
  `payu_referencia` varchar(255) NOT NULL,
  `pago_metodo` varchar(100) NOT NULL,
  `pago_valor` decimal(10,0) NOT NULL,
  `comprador_nombre` varchar(100) NOT NULL,
  `comprador_correo` varchar(255) NOT NULL,
  `comprador_tipo_documento` enum('CC','CE','TI','PPN','NIT','SSN','EIN') NOT NULL DEFAULT 'CC',
  `comprador_numero_documento` decimal(10,0) NOT NULL,
  `comprador_telefono` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `detalles_pagos` (`pago_id`, `pedido_id`, `payu_referencia`, `pago_metodo`, `pago_valor`, `comprador_nombre`, `comprador_correo`, `comprador_tipo_documento`, `comprador_numero_documento`, `comprador_telefono`) VALUES
('64b363a4-c543-4abb-a1f3-c03bded3e1ce', 'f306bf6e-18b8-4b46-ae38-a4fe05bdb4ec', 'compra-1997e4d2-fa0d-4cdd-b7a1-f970570a813e-1732037547386', 'VISA', 379800, 'APPROVED', 'andres52885241@gmail.com', 'CC', 1033707596, 3209202177);

CREATE TABLE `multimedias` (
  `multimedia_id` varchar(60) NOT NULL,
  `multimedia_url` varchar(255) NOT NULL,
  `multimedia_tipo` enum('imagen','video') NOT NULL,
  `producto_id` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `pedidos` (
  `pedido_id` varchar(60) NOT NULL,
  `usuario_id` varchar(60) NOT NULL,
  `pedido_fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `pedido_estado` enum('pendiente','enviando','entregado','recibido') NOT NULL DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `pedidos` (`pedido_id`, `usuario_id`, `pedido_fecha`, `pedido_estado`) VALUES
('f306bf6e-18b8-4b46-ae38-a4fe05bdb4ec', '1997e4d2-fa0d-4cdd-b7a1-f970570a813e', '2024-11-19 12:33:30', 'pendiente');

CREATE TABLE `productos` (
  `producto_id` varchar(60) NOT NULL,
  `producto_nombre` varchar(255) NOT NULL,
  `producto_descripcion` text NOT NULL,
  `producto_cantidad` int(11) NOT NULL,
  `producto_precio` decimal(10,0) NOT NULL,
  `producto_imagen_url` varchar(255) NOT NULL DEFAULT '/images/default.jpg',
  `producto_estado` enum('privado','publico') NOT NULL DEFAULT 'publico',
  `producto_fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_id` varchar(60) NOT NULL,
  `categoria_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `productos` (`producto_id`, `producto_nombre`, `producto_descripcion`, `producto_cantidad`, `producto_precio`, `producto_imagen_url`, `producto_estado`, `producto_fecha`, `usuario_id`, `categoria_id`) VALUES
('09fd4c7b-cd37-4e6d-a7f6-ae8f93734005', 'Rubik`s Cube', 'El clásico cubo de Rubik, con su diseño de colores vivos y su desafiante mecánica, es uno de los rompecabezas más populares y reconocidos del mundo.', 13, 15000, 'https://res.cloudinary.com/dyuh7jesr/image/upload/v1730360610/express-sale/products/09fd4c7b-cd37-4e6d-a7f6-ae8f93734005.jpg', 'publico', '2024-10-13 09:31:52', '1997e4d2-fa0d-4cdd-b7a1-f970570a813e', 4),
('10014419-f396-4639-925f-2b0814aa81f3', 'Nike Air Jordan 1', 'Las icónicas zapatillas Nike Air Jordan 1 son un clásico atemporal en el mundo de la moda urbana, conocidas por su estilo y comodidad.', 14, 289900, 'https://res.cloudinary.com/dyuh7jesr/image/upload/v1730360004/express-sale/products/10014419-f396-4639-925f-2b0814aa81f3.jpg', 'publico', '2024-10-13 09:36:21', '1dc76732-83ea-4a78-afb8-e759959ee5c3', 1),
('56a133ce-d6b7-4d63-9564-9fa656232efa', 'Megaplex | Creatine Power', 'Suplemento de proteína en polvo de alta calidad, ideal para la recuperación muscular y el crecimiento después del entrenamiento.', 9, 59900, 'https://res.cloudinary.com/dyuh7jesr/image/upload/v1730360834/express-sale/products/56a133ce-d6b7-4d63-9564-9fa656232efa.png', 'publico', '2024-10-13 09:31:07', '1997e4d2-fa0d-4cdd-b7a1-f970570a813e', 4),
('5d34b009-ce5b-4e20-950c-9b89dc4b09ae', 'KitKat', 'El delicioso chocolate KitKat, con sus característicos barquillos y su irresistible sabor, es el snack perfecto para disfrutar en cualquier momento del día.', 28, 4000, 'https://res.cloudinary.com/dyuh7jesr/image/upload/v1730360750/express-sale/products/5d34b009-ce5b-4e20-950c-9b89dc4b09ae.jpg', 'publico', '2024-10-13 09:33:06', 'b015e026-c217-4c39-962e-4d477c3640c9', 2),
('662c229a-a176-4f98-b3e1-0b3bb60ff5e0', 'PlayStation 5', 'La PlayStation 5 es la consola de última generación de Sony, que ofrece gráficos impresionantes, carga ultrarrápida y una amplia variedad de juegos exclusivos.', 12, 4599900, 'https://res.cloudinary.com/dyuh7jesr/image/upload/v1730360694/express-sale/products/662c229a-a176-4f98-b3e1-0b3bb60ff5e0.jpg', 'publico', '2024-10-13 09:34:59', 'e7864790-7e10-4af8-af5f-67b1af7cc1f6', 3),
('8c468cdc-7cf2-4ffa-99e2-b4e8310fc715', 'Xbox Series X', 'La Xbox Series X ofrece potencia de próxima generación, velocidades de carga ultrarrápidas y una amplia biblioteca de juegos para una experiencia de juego inigualable.', 13, 3599900, 'https://res.cloudinary.com/dyuh7jesr/image/upload/v1730360678/express-sale/products/8c468cdc-7cf2-4ffa-99e2-b4e8310fc715.png', 'publico', '2024-10-13 09:33:56', 'e7864790-7e10-4af8-af5f-67b1af7cc1f6', 3),
('a9458fa5-cc05-4a77-a1dc-9ff1378b1465', 'Casio G-Shock GA-2100', 'El reloj Casio G-Shock GA-2100 es conocido por su resistencia y estilo, con características como resistencia a golpes, al agua y un diseño moderno y elegante.', 10, 224000, 'https://res.cloudinary.com/dyuh7jesr/image/upload/v1730360642/express-sale/products/a9458fa5-cc05-4a77-a1dc-9ff1378b1465.jpg', 'publico', '2024-10-13 09:36:30', '1dc76732-83ea-4a78-afb8-e759959ee5c3', 1),
('b0beb7fb-57b5-4881-a29f-c86581dbae19', 'Mancuernas Ajustables', 'Un par de mancuernas ajustables con diferentes pesos, perfectas para entrenamiento de fuerza en casa o en el gimnasio.', 8, 89900, 'https://res.cloudinary.com/dyuh7jesr/image/upload/v1730360593/express-sale/products/b0beb7fb-57b5-4881-a29f-c86581dbae19.jpg', 'publico', '2024-10-13 09:31:30', '1997e4d2-fa0d-4cdd-b7a1-f970570a813e', 4),
('ddc2a91d-65b6-4316-9222-84cde0759911', 'Nutella', 'La crema de avellanas Nutella, con su textura suave y su sabor dulce, es un imprescindible en el desayuno de millones de personas en todo el mundo.', 22, 7000, 'https://res.cloudinary.com/dyuh7jesr/image/upload/v1730360734/express-sale/products/ddc2a91d-65b6-4316-9222-84cde0759911.jpg', 'publico', '2024-10-13 09:32:50', 'b015e026-c217-4c39-962e-4d477c3640c9', 2),
('e359851d-9813-463f-aff9-3a552a887134', 'Cadena Cubana de Plata', 'Una cadena cubana de plata es un accesorio clásico y llamativo que puede complementar cualquier atuendo, ya sea casual o más elegante.', 9, 31200, 'https://res.cloudinary.com/dyuh7jesr/image/upload/v1730360627/express-sale/products/e359851d-9813-463f-aff9-3a552a887134.jpg', 'publico', '2024-10-13 09:36:50', '1dc76732-83ea-4a78-afb8-e759959ee5c3', 1),
('e3e3e594-5c65-433f-a4a3-94f75dd4aef9', 'Galletas Oreo', 'Las deliciosas galletas Oreo, con su crujiente galleta y su cremoso relleno de vainilla, son un clásico de la merienda que gusta a niños y adultos por igual.', 40, 26900, 'https://res.cloudinary.com/dyuh7jesr/image/upload/v1730360709/express-sale/products/e3e3e594-5c65-433f-a4a3-94f75dd4aef9.jpg', 'publico', '2024-10-13 09:32:41', 'b015e026-c217-4c39-962e-4d477c3640c9', 2),
('fba1a2fb-3e81-447e-adf5-e984682d700d', 'iPhone 13 Pro', 'El iPhone 13 Pro es el último modelo de Apple que combina un diseño elegante con un rendimiento potente y cámaras avanzadas para capturar imágenes impresionantes.', 8, 2100000, 'https://res.cloudinary.com/dyuh7jesr/image/upload/v1730360661/express-sale/products/fba1a2fb-3e81-447e-adf5-e984682d700d.jpg', 'publico', '2024-10-13 09:35:12', 'e7864790-7e10-4af8-af5f-67b1af7cc1f6', 3);

CREATE TABLE `productos_pedidos` (
  `pedido_id` varchar(60) NOT NULL,
  `producto_id` varchar(60) NOT NULL,
  `producto_precio` decimal(10,0) NOT NULL,
  `producto_cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `productos_pedidos` (`pedido_id`, `producto_id`, `producto_precio`, `producto_cantidad`) VALUES
('f306bf6e-18b8-4b46-ae38-a4fe05bdb4ec', '10014419-f396-4639-925f-2b0814aa81f3', 289900, 1),
('f306bf6e-18b8-4b46-ae38-a4fe05bdb4ec', '09fd4c7b-cd37-4e6d-a7f6-ae8f93734005', 15000, 2),
('f306bf6e-18b8-4b46-ae38-a4fe05bdb4ec', '56a133ce-d6b7-4d63-9564-9fa656232efa', 59900, 1);

CREATE TABLE `recuperacion_cuentas` (
  `recuperacion_id` varchar(60) NOT NULL,
  `usuario_id` varchar(60) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_expiracion` timestamp NOT NULL DEFAULT (current_timestamp() + interval 1 hour)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `retiros` (
  `retiro_id` varchar(60) NOT NULL,
  `trabajador_id` varchar(60) NOT NULL,
  `retiro_valor` decimal(10,2) NOT NULL,
  `retiro_fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `roles` (
  `rol_id` int(11) NOT NULL,
  `rol_nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `roles` (`rol_id`, `rol_nombre`) VALUES
(1, 'cliente'),
(2, 'vendedor'),
(3, 'domiciliario'),
(4, 'administrador');

CREATE TABLE `sesiones` (
  `sid` varchar(36) NOT NULL,
  `expires` datetime DEFAULT NULL,
  `data` text DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `sesiones` (`sid`, `expires`, `data`, `createdAt`, `updatedAt`) VALUES
('NGPZYy6kStxMJ7iy5HwZHvu0zaU7QSQU', '2024-11-20 17:34:11', '{\"cookie\":{\"originalMaxAge\":86400000,\"expires\":\"2024-11-20T17:33:30.349Z\",\"secure\":false,\"httpOnly\":true,\"path\":\"/\",\"sameSite\":\"lax\"},\"usuario_id\":\"1997e4d2-fa0d-4cdd-b7a1-f970570a813e\",\"user\":{\"usuario_id\":\"1997e4d2-fa0d-4cdd-b7a1-f970570a813e\",\"usuario_nombre\":\"Andrés\",\"usuario_apellido\":\"Gutiérrez Hurtado\",\"usuario_correo\":\"andres52885241@gmail.com\",\"usuario_alias\":\"Andres_Gutierrez\",\"usuario_telefono\":\"3209202177\",\"usuario_direccion\":\"Dg. 68D Sur #70c-31, Bogotá, Colombia\",\"usuario_contra\":\"$2a$10$mwjk.9LQkXn0Q/OtdB5k6uZU6Diaw07lzT.75hx9O/1bbDwwEzYIW\",\"usuario_creacion\":\"2024-02-13T14:23:50.000Z\",\"usuario_actualizacion\":\"2024-10-31T12:16:44.000Z\",\"usuario_imagen_url\":\"https://res.cloudinary.com/dyuh7jesr/image/upload/v1730359008/express-sale/users/1997e4d2-fa0d-4cdd-b7a1-f970570a813e.jpg\",\"rol_id\":2,\"domiciliario_domicilio\":null,\"worker\":{\"trabajador_id\":\"3439d1be-f5ee-4a34-98e7-accec2eb1729\",\"trabajador_descripcion\":\"usuario nuevo.\",\"trabajador_saldo\":\"89900\",\"usuario_id\":\"1997e4d2-fa0d-4cdd-b7a1-f970570a813e\"},\"role\":{\"rol_id\":2,\"rol_nombre\":\"vendedor\"}}}', '2024-11-19 17:32:18', '2024-11-19 17:34:11');

CREATE TABLE `trabajadores` (
  `trabajador_id` varchar(60) NOT NULL,
  `trabajador_descripcion` text NOT NULL DEFAULT 'usuario nuevo.',
  `trabajador_saldo` decimal(10,0) NOT NULL DEFAULT 0,
  `usuario_id` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `trabajadores` (`trabajador_id`, `trabajador_descripcion`, `trabajador_saldo`, `usuario_id`) VALUES
('0b89b820-4c52-4ebd-aa4f-18262eac02db', 'usuario nuevo.', 0, 'b015e026-c217-4c39-962e-4d477c3640c9'),
('285dd857-d030-4f90-a193-5383500b0963', 'usuario nuevo.', 0, 'e7864790-7e10-4af8-af5f-67b1af7cc1f6'),
('3439d1be-f5ee-4a34-98e7-accec2eb1729', 'usuario nuevo.', 89900, '1997e4d2-fa0d-4cdd-b7a1-f970570a813e'),
('4859698d-85f6-4e33-a668-c10a7d2a5a2d', 'usuario nuevo.', 0, '2078ad6a-1373-4940-90a0-bf4bf1228e73'),
('5a5c533d-55f8-469e-b3a3-724deba8c0ad', 'usuario nuevo.', 289900, '1dc76732-83ea-4a78-afb8-e759959ee5c3');

CREATE TABLE `usuarios` (
  `usuario_id` varchar(60) NOT NULL,
  `usuario_nombre` varchar(100) NOT NULL,
  `usuario_apellido` varchar(100) NOT NULL,
  `usuario_correo` varchar(255) NOT NULL,
  `usuario_alias` varchar(50) NOT NULL,
  `usuario_telefono` decimal(10,0) DEFAULT NULL,
  `usuario_direccion` text DEFAULT NULL,
  `usuario_contra` text NOT NULL,
  `usuario_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuario_imagen_url` varchar(255) DEFAULT '/images/default.jpg',
  `rol_id` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `usuarios` (`usuario_id`, `usuario_nombre`, `usuario_apellido`, `usuario_correo`, `usuario_alias`, `usuario_telefono`, `usuario_direccion`, `usuario_contra`, `usuario_creacion`, `usuario_actualizacion`, `usuario_imagen_url`, `rol_id`) VALUES
('0cb61e19-b59f-4d7e-83e6-ec4de605b3ee', 'Luna Sofia', 'Pinzon Bejarano', 'lunasofiapinzonbejarano@gmail.com', 'Luna_Pinzon', 3027447950, 'Cl. 65 Sur #78h-65, Bogotá, Colombia', '$2a$10$kxkYAIQa/o5iJHy6Mn1C3.9jRVvnCF0UZnqJgRxL0LCy6NAJa.B7G', '2024-08-13 09:26:19', '2024-02-10 09:26:19', '/images/default.jpg', 1),
('1997e4d2-fa0d-4cdd-b7a1-f970570a813e', 'Andrés', 'Gutiérrez Hurtado', 'andres52885241@gmail.com', 'Andres_Gutierrez', 3209202177, 'Dg. 68D Sur #70c-31, Bogotá, Colombia', '$2a$10$mwjk.9LQkXn0Q/OtdB5k6uZU6Diaw07lzT.75hx9O/1bbDwwEzYIW', '2024-02-13 09:23:50', '2024-10-31 07:16:44', 'https://res.cloudinary.com/dyuh7jesr/image/upload/v1730359008/express-sale/users/1997e4d2-fa0d-4cdd-b7a1-f970570a813e.jpg', 2),
('1dc76732-83ea-4a78-afb8-e759959ee5c3', 'David Fernando', 'Diaz Niausa', 'davidfernandodiazniausa@gmail.com', 'David_Diaz', 3214109557, 'Cra. 5i Este #89-23, Bogotá, Colombia', '$2a$10$aNvO8Br.5mKKqpzNAuoO4umUP0ZRB..dFtttiA3n7DObEN/x1cW/y', '2024-03-13 09:23:54', '2024-10-31 07:17:43', 'https://res.cloudinary.com/dyuh7jesr/image/upload/v1730359067/express-sale/users/1dc76732-83ea-4a78-afb8-e759959ee5c3.jpg', 2),
('2078ad6a-1373-4940-90a0-bf4bf1228e73', 'Samuel', 'Useche Chaparro', 'samuuseche01@gmail.com', 'Samuel_Useche', 3107838443, 'Cl. 68f Sur #71g-82, Bogotá, Colombia', '$2a$10$XWDYW/hzBQuStDg4WTyUn.N2lH3VloZVx2.U4raQ.FkCfWQsmt3N.', '2024-06-13 09:24:10', '2024-05-02 09:24:10', '/images/default.jpg', 3),
('764ca4c3-b387-4be5-ab11-8d39db2e99af', 'Kevin Alejandro', 'Parra Cifuentes', 'luisparra5380@gmail.com', 'Kevin_Parra', 0, '3212376552', '$2a$10$wRvGOuETCvUYQvJx9K/2t.LwY4DG6/l5SE6UX7vTDQavIvahS1EO6', '2024-07-14 09:24:19', '2024-10-13 09:24:19', '/images/default.jpg', 1),
('7d7aa315-f996-4316-8af4-86fe4786ce4b', 'Wendy Alejandra', 'Navarro Arias', 'nwendy798@gmail.com', 'Wendy_Navarro', 3044462452, 'Dg. 69 Sur #68-20, Bogotá, Colombia', '$2a$10$z1yVOAC4MEPVxGl4WjQQmeX078Rq7eJEfE9UOyYSVLj79FlsYSBlq', '2024-09-22 09:26:37', '2024-10-13 09:26:37', '/images/default.jpg', 1),
('a30cd113-2e9a-4e8b-87f2-7cb7e27ff27f', 'Express', 'Sale', 'expresssale.exsl@gmail.com', 'Express_Sale', NULL, NULL, '$2a$10$LLVuZDAM7c5rwvuDdbqIJumcy1tIAbWCNFO4DxB6KLCYaqqQ7wbKW', '2024-01-17 09:23:43', '2024-10-31 07:17:28', 'https://res.cloudinary.com/dyuh7jesr/image/upload/v1730359052/express-sale/users/a30cd113-2e9a-4e8b-87f2-7cb7e27ff27f.jpg', 4),
('b015e026-c217-4c39-962e-4d477c3640c9', 'Juan Sebastian', 'Bernal Gamboa', 'juansebastianbernalgamboa@gmail.com', 'Juan_Bernal', 3053964455, 'Cra. 5i Este #89-23, Bogotá, Colombia', '$2a$10$g0iPipqxpIAsbFdHXEW3femJivexGekXSXrc2EHICLfdipOZVsP7G', '2024-04-15 09:24:02', '2024-10-31 07:18:05', 'https://res.cloudinary.com/dyuh7jesr/image/upload/v1730359088/express-sale/users/b015e026-c217-4c39-962e-4d477c3640c9.jpg', 2),
('e7864790-7e10-4af8-af5f-67b1af7cc1f6', 'Jaider Harley', 'Rondon Herrera', 'rondonjaider@gmail.com', 'Jaider_Rondon', 3112369205, 'Cra. 5i Este #89-23, Bogotá, Colombia', '$2a$10$QjOD1CqPAYG/eyzzy2neneB50f78LmQqqirNg.Sv4gfTL1efYEpBO', '2024-05-05 09:23:57', '2024-10-31 07:18:17', 'https://res.cloudinary.com/dyuh7jesr/image/upload/v1730359101/express-sale/users/e7864790-7e10-4af8-af5f-67b1af7cc1f6.jpg', 2);


ALTER TABLE `calificaciones`
  ADD PRIMARY KEY (`calificacion_id`),
  ADD KEY `fk_calificaciones_usuarios` (`usuario_id`);

ALTER TABLE `calificaciones_productos`
  ADD KEY `fk_calificaciones_productos_calificaciones` (`calificacion_id`),
  ADD KEY `fk_calificaciones_productos_productos` (`producto_id`);

ALTER TABLE `calificaciones_usuarios`
  ADD KEY `fk_calificaciones_usuarios_calificaciones` (`calificacion_id`),
  ADD KEY `fk_calificaciones_usuarios_usuarios` (`usuario_id`);

ALTER TABLE `carritos`
  ADD PRIMARY KEY (`carrito_id`),
  ADD KEY `fk_carritos_usuarios` (`usuario_id`),
  ADD KEY `fk_carritos_productos` (`producto_id`);

ALTER TABLE `categorias`
  ADD PRIMARY KEY (`categoria_id`);

ALTER TABLE `detalles_envios`
  ADD PRIMARY KEY (`envio_id`),
  ADD KEY `fk_detalles_envios_pedidos` (`pedido_id`),
  ADD KEY `fk_detalles_envios_trabajadores` (`trabajador_id`);

ALTER TABLE `detalles_pagos`
  ADD PRIMARY KEY (`pago_id`),
  ADD KEY `fk_detalles_pagos_pedidos` (`pedido_id`);

ALTER TABLE `multimedias`
  ADD PRIMARY KEY (`multimedia_id`),
  ADD KEY `fk_multimedia_productos` (`producto_id`);

ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`pedido_id`),
  ADD KEY `fk_pedidos_usuarios` (`usuario_id`);

ALTER TABLE `productos`
  ADD PRIMARY KEY (`producto_id`),
  ADD KEY `fk_productos_usuarios` (`usuario_id`),
  ADD KEY `fk_productos_categorias` (`categoria_id`);

ALTER TABLE `productos_pedidos`
  ADD KEY `fk_productos_pedidos_pedidos` (`pedido_id`),
  ADD KEY `fk_productos_pedidos_productos` (`producto_id`);

ALTER TABLE `recuperacion_cuentas`
  ADD PRIMARY KEY (`recuperacion_id`),
  ADD KEY `fk_recuperacion_cuentas_usuarios` (`usuario_id`);

ALTER TABLE `retiros`
  ADD PRIMARY KEY (`retiro_id`),
  ADD KEY `fk_retiros_usuarios` (`trabajador_id`);

ALTER TABLE `roles`
  ADD PRIMARY KEY (`rol_id`);

ALTER TABLE `trabajadores`
  ADD PRIMARY KEY (`trabajador_id`),
  ADD KEY `fk_trabajadores_usuarios` (`usuario_id`);

ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario_id`),
  ADD UNIQUE KEY `usuario_correo` (`usuario_correo`),
  ADD KEY `fk_usuarios_roles` (`rol_id`);


ALTER TABLE `categorias`
  MODIFY `categoria_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `roles`
  MODIFY `rol_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;


ALTER TABLE `calificaciones`
  ADD CONSTRAINT `fk_calificaciones_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `calificaciones_productos`
  ADD CONSTRAINT `fk_calificaciones_productos_calificaciones` FOREIGN KEY (`calificacion_id`) REFERENCES `calificaciones` (`calificacion_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_calificaciones_productos_productos` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`producto_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `calificaciones_usuarios`
  ADD CONSTRAINT `fk_calificaciones_usuarios_calificaciones` FOREIGN KEY (`calificacion_id`) REFERENCES `calificaciones` (`calificacion_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_calificaciones_usuarios_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `carritos`
  ADD CONSTRAINT `fk_carritos_productos` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`producto_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_carritos_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `detalles_envios`
  ADD CONSTRAINT `fk_detalles_envios_pedidos` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`pedido_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detalles_envios_trabajadores` FOREIGN KEY (`trabajador_id`) REFERENCES `trabajadores` (`trabajador_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `detalles_pagos`
  ADD CONSTRAINT `fk_detalles_pagos_pedidos` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`pedido_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `multimedias`
  ADD CONSTRAINT `fk_multimedia_productos` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`producto_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedidos_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `productos`
  ADD CONSTRAINT `fk_productos_categorias` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`categoria_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_productos_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `productos_pedidos`
  ADD CONSTRAINT `fk_productos_pedidos_pedidos` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`pedido_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_productos_pedidos_productos` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`producto_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `recuperacion_cuentas`
  ADD CONSTRAINT `fk_recuperacion_cuentas_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `retiros`
  ADD CONSTRAINT `fk_retiros_usuarios` FOREIGN KEY (`trabajador_id`) REFERENCES `trabajadores` (`trabajador_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `trabajadores`
  ADD CONSTRAINT `fk_trabajadores_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_roles` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`rol_id`) ON DELETE CASCADE ON UPDATE CASCADE;
