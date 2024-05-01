CREATE DATABASE `express-sale-db`;
USE `express-sale-db`;

-- Create users table
CREATE TABLE `users` (
    `user_id` INT PRIMARY KEY AUTO_INCREMENT,
    `full_name` VARCHAR(100) NOT NULL,
    `username` VARCHAR(100) UNIQUE NOT NULL,
    `email` VARCHAR(100) UNIQUE NOT NULL,
    `description` TEXT, 
    `rating` DECIMAL(3, 2),
    `votes` INT DEFAULT 0,
    `phone_number` DECIMAL(10),
    `address` VARCHAR(255),
    `image` VARCHAR(100),
    `password` TEXT NOT NULL,
    `role_id` INT NOT NULL
);

-- Insert data into users table
INSERT INTO `users` (`user_id`, `full_name`, `email`, `username`, `phone_number`, `address`, `image`, `password`, `role_id`, `description`, `rating`) VALUES 
(1, 'Express Sale', 'express_sale@gmail.com', 'Express_Sale', 3209202177, 'Bogotá(Ciudad Bolivar, Usme)', '/public/images/nf.png', '1234', 3, NULL, NULL),
(2, 'Andrés Gutiérrez Hurtado', 'andres52885241@gmail.com', 'Andres_Gutierrez', 3209202177, 'Dg 68 D sur 70C 31', '/public/images/users/nf.jpg', '1234', 2, 'Vendedor.', 0.00),
(3, 'David Fernando Diaz Niausa', 'davidfernandodiazniausa@gmail.com', 'David_Diaz', 1231231212, 'Usme', '/public/images/users/nf.jpg', '1234', 2, 'Vendedor.', 0.00),
(4, 'Jaider Harley Rondón Herrera', 'rondonjaider@gmail.com', 'Jaider_Rondon', 1231231212, 'Usme', '/public/images/users/nf.jpg', '1234', 2, 'Vendedor.', 0.00),
(5, 'Juan Sebastian Bernal Gamboa', 'juansebastianbernalgamboa@gmail.com', 'Juan_Sebastian', 1231231212, 'Usme', '/public/images/users/nf.jpg', '1234', 2, 'Vendedor.', 0.00),
(6, 'Wendy Alejandra Navarro Arias', 'nwendy798@gmail.com', 'Wendy_Navarro', 3044462452, 'El ensueño', '/public/images/users/nf.jpg', '1234', 1, NULL, NULL);

-- Create products table
CREATE TABLE `products` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `description` TEXT,
    `price` DECIMAL(10, 2) NOT NULL,
    `stock` INT NOT NULL,
    `image` VARCHAR(100),
    `rating` DECIMAL(3, 2),
    `votes` INT DEFAULT 0,
    `category_id` INT,
    `user_id` INT, 
    `date`DATE,
    `state` ENUM('public', 'private') DEFAULT 'public'
);

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `image`, `rating`, `category_id`, `user_id`, `state`, `date`) VALUES
(1, 'Nike Air Jordan 1', 'Las icónicas zapatillas Nike Air Jordan 1 son un clásico atemporal en el mundo de la moda urbana, conocidas por su estilo y comodidad.', 289900.00, 7, '/public/images/products/1.jpg', 0, 1, 3, 'public', '2024-01-15'),
(2, 'Cadena Cubana de Plata', 'Una cadena cubana de plata es un accesorio clásico y llamativo que puede complementar cualquier atuendo, ya sea casual o más elegante.', 24900.00, 10, '/public/images/products/2.jpg', 0, 1, 3, 'public', '2024-02-20'),
(3, 'Casio G-Shock GA-2100', 'El reloj Casio G-Shock GA-2100 es conocido por su resistencia y estilo, con características como resistencia a golpes, al agua y un diseño moderno y elegante.', 224000.00, 9, '/public/images/products/3.jpg', 0, 1, 3, 'public', '2024-03-05'),
(4, 'iPhone 13 Pro', 'El iPhone 13 Pro es el último modelo de Apple que combina un diseño elegante con un rendimiento potente y cámaras avanzadas para capturar imágenes impresionantes.', 2100000.00, 10, '/public/images/products/4.jpg', 0, 3, 4, 'public', '2024-04-10'),
(5, 'Xbox Series X', 'La Xbox Series X ofrece potencia de próxima generación, velocidades de carga ultrarrápidas y una amplia biblioteca de juegos para una experiencia de juego inigualable.', 3599900.00, 5, '/public/images/products/5.jpg', 0, 3, 4, 'public', '2024-01-25'),
(6, 'PlayStation 5', 'La PlayStation 5 es la consola de última generación de Sony, que ofrece gráficos impresionantes, carga ultrarrápida y una amplia variedad de juegos exclusivos.', 4599900.00, 7, '/public/images/products/6.jpg', 0, 3, 4, 'public', '2024-02-05'),
(7, 'Galletas Oreo', 'Las deliciosas galletas Oreo, con su crujiente galleta y su cremoso relleno de vainilla, son un clásico de la merienda que gusta a niños y adultos por igual.', 26900.00, 46, '/public/images/products/7.jpg', 0, 2, 5, 'public', '2024-03-15'),
(8, 'Nutella', 'La crema de avellanas Nutella, con su textura suave y su sabor dulce, es un imprescindible en el desayuno de millones de personas en todo el mundo.', 7000.00, 28, '/public/images/products/8.jpg', 0, 2, 5, 'public', '2024-04-20'),
(9, 'KitKat', 'El delicioso chocolate KitKat, con sus característicos barquillos y su irresistible sabor, es el snack perfecto para disfrutar en cualquier momento del día.', 4000.00, 34, '/public/images/products/9.jpg', 0, 2, 5, 'public', '2024-01-30'),
(10, 'Mancuernas Ajustables', 'Un par de mancuernas ajustables con diferentes pesos, perfectas para entrenamiento de fuerza en casa o en el gimnasio.', 89900.00, 10, '/public/images/products/10.jpg', 0, 4, 2, 'public', '2024-02-10'),
(11, 'Megaplex | Creatine Power', 'Suplemento de proteína en polvo de alta calidad, ideal para la recuperación muscular y el crecimiento después del entrenamiento.', 59900.00, 15, '/public/images/products/11.jpg', 0, 4, 2, 'public', '2024-03-20'),
(12, 'Rubik`s Cube', 'El clásico cubo de Rubik, con su diseño de colores vivos y su desafiante mecánica, es uno de los rompecabezas más populares y reconocidos del mundo.', 15000.00, 20, '/public/images/products/12.jpg', 0, 4, 2, 'public', '2024-04-27');

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
