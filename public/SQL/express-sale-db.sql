CREATE DATABASE `express-sale-db`;
USE `express-sale-db`;

-- Create users table
CREATE TABLE `users` (
    `user_id` INT PRIMARY KEY AUTO_INCREMENT,
    `full_name` VARCHAR(100) NOT NULL,
    `username` VARCHAR(100) UNIQUE NOT NULL,
    `email` VARCHAR(100) UNIQUE NOT NULL,
    `phone_number` DECIMAL(10),
    `address` VARCHAR(255),
    `image` VARCHAR(100),
    `password` TEXT NOT NULL,
    `account_type` INT,
    `role_id` INT NOT NULL
);

INSERT INTO `users` (`user_id`,`full_name`, `email`, `username`, `phone_number`, `address`, `image`, `password`, `account_type`, `role_id`) VALUES 
(1, 'Andrés Gutiérrez Hurtado', 'andres52885241@gmail.com', 'Andrés_Gutiérrez', 3209202177, 'Dg 68 D sur 70C 31', '/public/images/users/nf.jpg', '1234', 2, 3),
(2, 'David Fernando Diaz Niausa', 'davidfernandodiazniausa@gmail.com', 'David_Diaz', 3209998877, 'Usme', '/public/images/users/nf.jpg', '1234', 2, 2 ),
(3, 'Jaider Harley Rondón Herrera', 'jaiderrondonherrera@gmail.com', 'Jaider_Rondon', 3209998877, 'Usme', '/public/images/users/nf.jpg', '1234', 2, 1 );

-- Create products table with seller_id
CREATE TABLE `products` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `description` TEXT,
    `price` DECIMAL(10, 2) NOT NULL,
    `stock` INT NOT NULL,
    `image` VARCHAR(100),
    `calification` DECIMAL(2, 1),
    `category_id` INT,
    `user_id` INT, 
    `state` ENUM('public', 'hidden') DEFAULT 'public'
);

INSERT INTO `products` (`name`, `description`, `price`, `stock`, `image`, `category_id`, `calification`, `user_id`, `state`) VALUES 
    ('Camiseta Polo Ralph Lauren', 'Camiseta clásica de Polo Ralph Lauren, fabricada con algodón suave y con el icónico logo del jugador de polo bordado en el pecho.', 189900, 50, '/public/images/products/polo.jpg', 1, 4.5, 1, 'public'),
    ('Pantalones Vaqueros Levi\'s 501', 'Los legendarios pantalones vaqueros Levi\'s 501 ofrecen un ajuste clásico y duradero con un estilo atemporal que nunca pasa de moda.', 229900, 100, '/public/images/products/levis.jpg', 1, 4.7, 1, 'public'), 
    ('Zapatos Deportivos Nike Air Force 1', 'Los icónicos zapatos deportivos Nike Air Force 1 combinan comodidad y estilo con su diseño clásico y su suela Air-Sole para una amortiguación excepcional.', 289900, 30, '/public/images/products/airforce.jpg', 1, 4.8, 1, 'public'),
    ('Pizza Hawaiana Grande', 'Disfruta de una deliciosa pizza hawaiana grande con piña, jamón y salsa de tomate casera. Perfecta para compartir con amigos y familiares.', 34900, 20, '/public/images/products/pizza.jpg', 2, 4.3, 1, 'public'), 
    ('Hamburguesa Angus con Papas Fritas', 'Una jugosa hamburguesa Angus servida con pan recién horneado, acompañada de crujientes papas fritas. Una opción clásica para satisfacer tu antojo.', 26900, 10, '/public/images/products/hamburguesa.jpg', 2, 4.9, 1, 'public'),
    ('Sushi Variado para Dos Personas', 'Disfruta de una variedad de sushi fresco, incluyendo rollos de salmón, atún y aguacate, junto con nigiri de camarón y pulpo. Ideal para una cena romántica o una comida entre amigos.', 59900, 15, '/public/images/products/sushi.jpg', 2, 4.6, 1, 'public'),
    ('Samsung Galaxy A52', 'El Samsung Galaxy A52 ofrece un rendimiento excepcional con su procesador rápido, una pantalla Super AMOLED vibrante y una potente cámara cuádruple para capturar cada momento.', 1599900, 50, '/public/images/products/galaxya52.jpg', 3, 4.5, 1, 'public'),
    ('Apple Watch Series 7', 'El Apple Watch Series 7 te ayuda a mantener un estilo de vida activo y conectado con funciones avanzadas de salud, una pantalla más grande y una duración de la batería mejorada.', 1799900, 30, '/public/images/products/applewatch.jpg', 3, 4.7, 1, 'public'), 
    ('Laptop HP Pavilion 15', 'La laptop HP Pavilion 15 combina rendimiento y portabilidad con un diseño elegante y especificaciones potentes, ideal para trabajar, estudiar o disfrutar del entretenimiento multimedia.', 2499900, 20, '/public/images/products/hplaptop.jpg', 3, 4.8, 1, 'public'),
    ('Lámpara de Escritorio LED', 'Esta lámpara de escritorio LED ofrece iluminación ajustable con diferentes modos de luz para adaptarse a tus necesidades de lectura, trabajo o relajación.', 89900, 20, '/public/images/products/lampara.jpg', 4, 4.3, 1, 'public'), 
    ('Termo Stanley de Acero Inoxidable', 'El termo Stanley de acero inoxidable mantiene tus bebidas calientes o frías durante horas, perfecto para llevar café, té o agua mientras estás en movimiento.', 189900, 10, '/public/images/products/termo.jpg', 4, 4.9, 1, 'public'),
    ('Mochila Táctica Militar', 'Esta mochila táctica militar está diseñada para resistir condiciones extremas y ofrece amplio espacio de almacenamiento para tus aventuras al aire libre o tus desplazamientos diarios.', 169900, 15, '/public/images/products/mochila.jpg', 4, 4.6, 1, 'public');


-- Create sales table
CREATE TABLE `sales` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `sales_products` TEXT,
    `user_id` INT,
    `stock` INT NOT NULL,
    `sale_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create account_types table
CREATE TABLE `account_types` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `type_name` VARCHAR(50) NOT NULL
);

-- Insert predefined account types
INSERT INTO `account_types` (`id`,`type_name`) VALUES 
(1, 'standard'), 
(2, 'premium');

-- Create roles table
CREATE TABLE `roles` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL
);

-- Insert predefined roles
INSERT INTO `roles` (`id`, `name`) VALUES 
(1, 'usuario'),
(2, 'vendedor'),
(3, 'administrador');

-- Create categories table
CREATE TABLE `categories` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL
);

-- Insert predefined categories
INSERT INTO `categories` (`id`,`name`) VALUES 
(1, 'moda'),
(2, 'comida'),
(3, 'tecnologia'),
(4, 'otros');

-- Add foreign keys
ALTER TABLE `users` 
ADD FOREIGN KEY (`role_id`) 
REFERENCES `roles`(`id`);

ALTER TABLE `products` 
ADD FOREIGN KEY (`user_id`) 
REFERENCES `users`(`user_id`);

ALTER TABLE `products` 
ADD FOREIGN KEY (`category_id`) 
REFERENCES `categories`(`id`);

ALTER TABLE `sales` 
ADD FOREIGN KEY (`user_id`) 
REFERENCES `users`(`user_id`);

ALTER TABLE `users`
ADD FOREIGN KEY (`account_type`) 
REFERENCES `account_types`(`id`);
