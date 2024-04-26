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
    `role_id` INT NOT NULL
);

INSERT INTO `users` (`user_id`,`full_name`, `email`, `username`, `phone_number`, `address`, `image`, `password`, `role_id`) VALUES 
(1, 'Express Sale', 'express_sale@gmail.com', 'Express_Sale', 1231231212, 'Bogotá', '/public/images/logo.png', '1234', 3),
(2, 'Andrés Gutiérrez Hurtado', 'andres52885241@gmail.com', 'Andres_Gutierrez', 3209202177, 'Dg 68 D sur 70C 31', '/public/images/users/1.jpg', '1234', 2),
(3, 'David Fernando Diaz Niausa', 'davidfernandodiazniausa@gmail.com', 'David_Diaz', 1231231212, 'Usme', '/public/images/users/nf.jpg', '1234', 2 ),
(4, 'Jaider Harley Rondón Herrera', 'rondonjaider@gmail.com', 'Jaider_Rondon', 1231231212, 'Usme', '/public/images/users/nf.jpg', '1234', 2 ),
(5, 'Juan Sebastian Bernal Gamboa', 'juansebastianbernalgamboa@gmail.com', 'Juan_Sebastian', 1231231212, 'Usme', '/public/images/users/nf.jpg', '1234', 2 ),
(6, 'Wendy Alejandra Navarro Arias', 'nwendy798@gmail.com', 'Wendy_Navarro', 3044462452, 'El ensueño', '/public/images/users/nf.jpg', '1234', 1 );

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
    ('Nike Air Jordan 1', 'Las icónicas zapatillas Nike Air Jordan 1 son un clásico atemporal en el mundo de la moda urbana, conocidas por su estilo y comodidad.', 289900, 7, '/public/images/products/nf.jpg', 1, 4.5, 3, 'public'), -- David
    ('Cadena Cubana de Plata', 'Una cadena cubana de plata es un accesorio clásico y llamativo que puede complementar cualquier atuendo, ya sea casual o más elegante.', 24900, 10, '/public/images/products/nf.jpg', 1, 4.8, 3, 'public'), -- David
    ('Casio G-Shock GA-2100', 'El reloj Casio G-Shock GA-2100 es conocido por su resistencia y estilo, con características como resistencia a golpes, al agua y un diseño moderno y elegante.', 224000, 9, '/public/images/products/nf.jpg', 1, 4.8, 3, 'public'), -- David
    ('iPhone 13 Pro', 'El iPhone 13 Pro es el último modelo de Apple que combina un diseño elegante con un rendimiento potente y cámaras avanzadas para capturar imágenes impresionantes.', 2100000, 10, '/public/images/products/nf.jpg', 3, 4.5, 4, 'public'), -- Jaider
    ('Xbox Series X', 'La Xbox Series X ofrece potencia de próxima generación, velocidades de carga ultrarrápidas y una amplia biblioteca de juegos para una experiencia de juego inigualable.', 3599900, 5, '/public/images/products/nf.jpg', 3, 4.5, 4, 'public'), -- Jaider
    ('PlayStation 5', 'La PlayStation 5 es la consola de última generación de Sony, que ofrece gráficos impresionantes, carga ultrarrápida y una amplia variedad de juegos exclusivos.', 4599900, 7, '/public/images/products/nf.jpg', 3, 4.8, 4, 'public'), -- Jaider
    ('Galletas Oreo', 'Las deliciosas galletas Oreo, con su crujiente galleta y su cremoso relleno de vainilla, son un clásico de la merienda que gusta a niños y adultos por igual.', 26900, 46, '/public/images/products/nf.jpg', 2, 4.9, 5, 'public'), -- Juan Sebastian
    ('Nutella', 'La crema de avellanas Nutella, con su textura suave y su sabor dulce, es un imprescindible en el desayuno de millones de personas en todo el mundo.', 7000, 28, '/public/images/products/nf.jpg', 2, 4.6, 5, 'public'), -- Juan Sebastian
    ('KitKat', 'El delicioso chocolate KitKat, con sus característicos barquillos y su irresistible sabor, es el snack perfecto para disfrutar en cualquier momento del día.', 4000, 34, '/public/images/products/nf.jpg', 2, 4.9, 5, 'public'), -- Juan Sebastian
    ('Mancuernas Ajustables', 'Un par de mancuernas ajustables con diferentes pesos, perfectas para entrenamiento de fuerza en casa o en el gimnasio.', 89900, 10, '/public/images/products/nf.jpg', 4, 4.7, 2, 'public'), -- Andrés
    ('Proteína en Polvo', 'Suplemento de proteína en polvo de alta calidad, ideal para la recuperación muscular y el crecimiento después del entrenamiento.', 59900, 15, '/public/images/products/nf.jpg', 4, 4.5, 2, 'public'), -- Andrés
    ('Rubik`s Cube', 'El clásico cubo de Rubik, con su diseño de colores vivos y su desafiante mecánica, es uno de los rompecabezas más populares y reconocidos del mundo.', 15000, 20, '/public/images/products/nf.jpg', 4, 4.3, 2, 'public'); -- Andrés


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
