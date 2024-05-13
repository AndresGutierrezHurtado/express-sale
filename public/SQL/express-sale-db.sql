DROP DATABASE IF EXISTS `express-sale-db`;
CREATE DATABASE `express-sale-db`;
USE `express-sale-db`;

DROP TABLE IF EXISTS `users`, `workers`, `roles`, `images`, `califications`, `products`, `categories`, `states`, `orders`, `sold_products`, `receipts`, `pay_method`;

-- ---------------------------------------------------------------
--
-- Create users table
CREATE TABLE `users` (
    `user_id` INT PRIMARY KEY AUTO_INCREMENT,
    `user_first_name` VARCHAR(40) NOT NULL,
    `user_last_name` VARCHAR(50) NOT NULL,
    `user_document_type` ENUM('CC', 'TI', 'CE') DEFAULT 'CC',
    `user_document_number` DECIMAL(10, 0) UNIQUE NOT NULL,
    `user_email`VARCHAR(50) UNIQUE NOT NULL,
    `user_username` VARCHAR(30) UNIQUE NOT NULL,
    `user_phone_number` DECIMAL(10),
    `user_address` VARCHAR(100),
    `user_password` VARCHAR(150),
    `user_role_id` INT DEFAULT 1
);

-- Insert data into users table
INSERT INTO `users` (`user_id`, `user_first_name`, `user_last_name`, `user_document_type`, `user_document_number`, `user_email`, `user_username`, `user_phone_number`, `user_address`, `user_password`, `user_role_id`) VALUES
(1, 'Express', 'Sale', 'CC', 0, 'express_sale@gmail.com', 'Express_Sale', 3209202177, 'Bogotá, Colombia', '1234', 4),
(2, 'Andrés', 'Gutiérrez Hurtado', 'TI', 1033707596, 'andres52885241@gmail.com', 'Andres_Gutierrez', 3209202177, 'Dg. 68D Sur #70c-31, Bogotá, Colombia', '1234', 2),
(3, 'David Fernando', 'Diaz Niausa', 'TI', 1, 'davidfernandodiazniausa@gmail.com', 'David_Diaz', 3214109557, 'Alfonso Lopez, Bogotá, Colombia', '1234', 2),
(4, 'Jaider Harley', 'Rondón Herrera', 'CC', 2, 'rondonjaider@gmail.com', 'Jaider_Rondon', 3112369205, 'Usme, Bogotá, Colombia', '1234', 2),
(5, 'Juan Sebastian', 'Bernal Gamboa', 'TI', 3, 'juansebastianbernalgamboa@gmail.com', 'Juan_Sebastian', 3053964455, 'Usme, Bogotá, Colombia', '1234', 2),
(6, 'Santiago', 'Hurtado Medina', 'TI', 4, 'shurtado@gmail.com', 'Santiago_Hurtado', 3208878515, 'Molinos del sur, Diagonal 49f Bis Sur, Bogotá, Colombia', '1234', 3),
(7, 'Wendy Alejandra', 'Navarro Arias', 'CC', 1025532941, 'nwendy798@gmail.com', 'Wendy_Navarro', 3044462452, 'Kalamary V, Diagonal 69 Sur, Bogotá, Colombia', '1234', 1);

-- ---------------------------------------------------------------
--
-- Create users table
CREATE TABLE `workers` (
    `worker_id` INT PRIMARY KEY AUTO_INCREMENT,
    `worker_description` TEXT DEFAULT 'Usuario nuevo.',
    `worker_works_done` INT DEFAULT 0,
    `worker_user_id` INT
);

INSERT INTO `workers` (`worker_user_id`) VALUES 
(2), -- Andres
(3), -- David
(4), -- Jaider
(5), -- Juan
(6); -- Santiago
-- ---------------------------------------------------------------
--
-- Create users table
CREATE TABLE `roles` (
    `role_id` INT PRIMARY KEY AUTO_INCREMENT,
    `role_name` VARCHAR(15)
);

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'cliente'),
(2, 'vendedor'),
(3, 'domiciliario'),
(4, 'administrador');

-- ---------------------------------------------------------------
--
-- Create users table
CREATE TABLE `images` (
    `image_id` INT PRIMARY KEY AUTO_INCREMENT,
    `image_object_type` ENUM('producto', 'usuario') DEFAULT 'usuario',
    `image_url` VARCHAR(50),
    `image_object_id` INT
);

-- Insertar imágenes para usuarios existentes
INSERT INTO images (image_object_type, image_url, image_object_id) 
VALUES 
('usuario', '/public/images/users/1.jpg', 1),
('usuario', '/public/images/users/2.jpg', 2),
('usuario', '/public/images/users/nf.jpg', 3),
('usuario', '/public/images/users/4.jpg', 4),
('usuario', '/public/images/users/nf.jpg', 5),
('usuario', '/public/images/users/6.jpg', 6),
('usuario', '/public/images/users/7.jpg', 7);

-- Insertar imágenes para productos existentes
INSERT INTO images (image_object_type, image_url, image_object_id) 
VALUES 
('producto', '/public/images/products/1.jpg', 1),
('producto', '/public/images/products/2.jpg', 2),
('producto', '/public/images/products/3.jpg', 3),
('producto', '/public/images/products/4.jpg', 4),
('producto', '/public/images/products/5.jpg', 5),
('producto', '/public/images/products/6.jpg', 6),
('producto', '/public/images/products/7.jpg', 7),
('producto', '/public/images/products/8.jpg', 8),
('producto', '/public/images/products/9.jpg', 9),
('producto', '/public/images/products/10.jpg', 10),
('producto', '/public/images/products/11.jpg', 11),
('producto', '/public/images/products/12.jpg', 12);

-- ---------------------------------------------------------------
--
-- Create users table
CREATE TABLE `califications` (
    `calification_id` INT PRIMARY KEY AUTO_INCREMENT,
    `calification_object_type`ENUM('producto', 'usuario') DEFAULT 'usuario',
    `calification_comment` TEXT,
    `calification` DECIMAL(3, 2),
    `calificator_user_id` INT,
    `calificated_object_id` INT
);

-- ---------------------------------------------------------------
--
-- Create users table
CREATE TABLE `products` (
    `product_id` INT PRIMARY KEY AUTO_INCREMENT,
    `product_name` VARCHAR(40) NOT NULL,
    `product_description` VARCHAR(200) NOT NULL,
    `product_price`DECIMAL(10, 2) NOT NULL,
    `product_stock` INT NOT NULL,
    `product_date` DATE NOT NULL,
    `product_category_id` INT NOT NULL,
    `product_user_id` INT,
    `product_state_id` INT
);

-- Insert data into products table with product_date
INSERT INTO `products` (`product_name`, `product_description`, `product_date`, `product_price`, `product_stock`, `product_category_id`, `product_user_id`, `product_state_id`) VALUES
-- Moda
('Nike Air Jordan 1', 'Las icónicas zapatillas Nike Air Jordan 1 son un clásico atemporal en el mundo de la moda urbana, conocidas por su estilo y comodidad.', '2024-02-01', 289900.00, 15, 1, 3, 1),
('Cadena Cubana de Plata', 'Una cadena cubana de plata es un accesorio clásico y llamativo que puede complementar cualquier atuendo, ya sea casual o más elegante.', '2024-03-25', 24900.00, 9, 1, 3, 1),
('Casio G-Shock GA-2100', 'El reloj Casio G-Shock GA-2100 es conocido por su resistencia y estilo, con características como resistencia a golpes, al agua y un diseño moderno y elegante.', '2024-04-20', 224000.00, 10, 1, 3, 1),
-- Tecnología
('iPhone 13 Pro', 'El iPhone 13 Pro es el último modelo de Apple que combina un diseño elegante con un rendimiento potente y cámaras avanzadas para capturar imágenes impresionantes.', '2024-05-10', 2100000.00, 8, 3, 4, 1),
('Xbox Series X', 'La Xbox Series X ofrece potencia de próxima generación, velocidades de carga ultrarrápidas y una amplia biblioteca de juegos para una experiencia de juego inigualable.', '2024-05-05', 3599900.00, 13, 3, 4, 1),
('PlayStation 5', 'La PlayStation 5 es la consola de última generación de Sony, que ofrece gráficos impresionantes, carga ultrarrápida y una amplia variedad de juegos exclusivos.', '2024-04-15', 4599900.00, 12, 3, 4, 1),
-- Comida
('Galletas Oreo', 'Las deliciosas galletas Oreo, con su crujiente galleta y su cremoso relleno de vainilla, son un clásico de la merienda que gusta a niños y adultos por igual.', '2024-03-01', 26900.00, 40, 2, 5, 1),
('Nutella', 'La crema de avellanas Nutella, con su textura suave y su sabor dulce, es un imprescindible en el desayuno de millones de personas en todo el mundo.', '2024-02-10', 7000.00, 22, 2, 5, 1),
('KitKat', 'El delicioso chocolate KitKat, con sus característicos barquillos y su irresistible sabor, es el snack perfecto para disfrutar en cualquier momento del día.', '2024-03-20', 4000.00, 28, 2, 5, 1),
-- Otros
('Mancuernas Ajustables', 'Un par de mancuernas ajustables con diferentes pesos, perfectas para entrenamiento de fuerza en casa o en el gimnasio.', '2024-04-05', 89900.00, 8, 4, 2, 1),
('Megaplex | Creatine Power', 'Suplemento de proteína en polvo de alta calidad, ideal para la recuperación muscular y el crecimiento después del entrenamiento.', '2024-05-01', 59900.00, 10, 4, 2, 1),
('Rubik`s Cube', 'El clásico cubo de Rubik, con su diseño de colores vivos y su desafiante mecánica, es uno de los rompecabezas más populares y reconocidos del mundo.', '2024-02-15', 15000.00, 15, 4, 2, 1);

-- ---------------------------------------------------------------
--
-- Create users table
CREATE TABLE `categories` (
    `category_id` INT PRIMARY KEY AUTO_INCREMENT,
    `category_name` VARCHAR(30)
);

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'moda'),
(2, 'comida'),
(3, 'tecnologia'),
(4, 'otros');

-- ---------------------------------------------------------------
--
-- Create users table
CREATE TABLE `states` (
    `state_id` INT PRIMARY KEY AUTO_INCREMENT,
    `state_name` VARCHAR(30)
);

INSERT INTO `states` (`state_id`, `state_name`) VALUES
(1, 'publico'),
(2, 'privado'),
(3, 'esperando'),
(4, 'enviando'),
(5, 'finalizado'),
(6, 'rechadazo');

-- ---------------------------------------------------------------
--
-- Create users table
CREATE TABLE `orders` (
    `order_id` INT PRIMARY KEY AUTO_INCREMENT,
    `order_date` DATE NOT NULL,
    `order_iva` DECIMAL(10, 2) NOT NULL,
    `order_amount` DECIMAL(10, 2) NOT NULL,
    `order_first_name` VARCHAR(60) NOT NULL,
    `order_last_name` VARCHAR(60) NOT NULL,
    `order_email` VARCHAR(80) NOT NULL,
    `order_phone_number` DECIMAL(10, 0) NOT NULL,
    `order_address` VARCHAR(100) NOT NULL,
    `order_coords` JSON NOT NULL,
    `order_user_id` INT NOT NULL,
    `order_worker_id` INT,
    `order_state_id` INT DEFAULT 3
);

-- ---------------------------------------------------------------
--
-- Create users table
CREATE TABLE `sold_products` (
    `sold_product_id` INT PRIMARY KEY AUTO_INCREMENT,
    `sold_product_product_id` INT,
    `sold_product_order_id` INT,
    `sold_product_quantity` INT,
    `sold_product_price` DECIMAL(10, 2),
    `sold_product_address` VARCHAR(100)    
);

-- ---------------------------------------------------------------
--
-- Create users table
CREATE TABLE `receipts` (
    `receipt_id` INT PRIMARY KEY AUTO_INCREMENT,
    `receipt_date` DATE,
    `receipt_time` TIME,
    `receipt_amount` DECIMAL(10, 2),
    `receipt_pay_form_id` INT DEFAULT 4,
    `receipt_order_id` INT
);

-- ---------------------------------------------------------------
--
-- Create users table
CREATE TABLE `pay_method` (
    `pay_method_id` INT PRIMARY KEY AUTO_INCREMENT,
    `pay_method_name` VARCHAR(30)
);

INSERT INTO `pay_method` (`pay_method_id`, `pay_method_name`) VALUES 
(2, 'CREDIT_CARD'),
(4, 'PSE'),
(5, 'ACH'),
(6, 'DEBIT_CARD'),
(7, 'CASH'),
(8, 'REFERENCED'),
(10, 'BANK_REFERENCED'),
(14, 'SPEI');
-- Agregar clave foránea a la tabla `users`
ALTER TABLE `users`
ADD CONSTRAINT `fk_user_role_id`
FOREIGN KEY (`user_role_id`)
REFERENCES `roles`(`role_id`)
ON UPDATE CASCADE
ON DELETE CASCADE;

-- Agregar clave foránea a la tabla `workers`
ALTER TABLE `workers`
ADD CONSTRAINT `fk_worker_user_id`
FOREIGN KEY (`worker_user_id`)
REFERENCES `users`(`user_id`)
ON UPDATE CASCADE
ON DELETE CASCADE;

-- Agregar clave foránea a la tabla `images`
ALTER TABLE `images`
ADD CONSTRAINT `fk_image_object_id`
FOREIGN KEY (`image_object_id`)
REFERENCES `products`(`product_id`)
ON UPDATE CASCADE
ON DELETE CASCADE;

-- Agregar clave foránea a la tabla `califications`
ALTER TABLE `califications`
ADD CONSTRAINT `fk_calificator_user_id`
FOREIGN KEY (`calificator_user_id`)
REFERENCES `users`(`user_id`)
ON UPDATE CASCADE
ON DELETE CASCADE;

-- Agregar clave foránea a la tabla `products`
ALTER TABLE `products`
ADD CONSTRAINT `fk_product_category_id`
FOREIGN KEY (`product_category_id`)
REFERENCES `categories`(`category_id`)
ON UPDATE CASCADE
ON DELETE CASCADE,
ADD CONSTRAINT `fk_product_user_id`
FOREIGN KEY (`product_user_id`)
REFERENCES `users`(`user_id`)
ON UPDATE CASCADE
ON DELETE CASCADE,
ADD CONSTRAINT `fk_product_state_id`
FOREIGN KEY (`product_state_id`)
REFERENCES `states`(`state_id`)
ON UPDATE CASCADE
ON DELETE CASCADE;

-- Agregar clave foránea a la tabla `orders`
ALTER TABLE `orders`
ADD CONSTRAINT `fk_order_user_id`
FOREIGN KEY (`order_user_id`)
REFERENCES `users`(`user_id`)
ON UPDATE CASCADE
ON DELETE CASCADE,
ADD CONSTRAINT `fk_order_worker_id`
FOREIGN KEY (`order_worker_id`)
REFERENCES `workers`(`worker_id`)
ON UPDATE CASCADE
ON DELETE CASCADE,
ADD CONSTRAINT `fk_order_state_id`
FOREIGN KEY (`order_state_id`)
REFERENCES `states`(`state_id`)
ON UPDATE CASCADE
ON DELETE CASCADE;

-- Agregar clave foránea a la tabla `sold_products`
ALTER TABLE `sold_products`
ADD CONSTRAINT `fk_sold_products_product_id`
FOREIGN KEY (`sold_product_product_id`)
REFERENCES `products`(`product_id`)
ON UPDATE CASCADE
ON DELETE CASCADE,
ADD CONSTRAINT `fk_sold_products_order_id`
FOREIGN KEY (`sold_product_order_id`)
REFERENCES `orders`(`order_id`)
ON UPDATE CASCADE
ON DELETE CASCADE;

-- Agregar clave foránea a la tabla `receipts`
ALTER TABLE `receipts`
ADD CONSTRAINT `fk_receipt_pay_form_id`
FOREIGN KEY (`receipt_pay_form_id`)
REFERENCES `pay_method`(`pay_method_id`)
ON UPDATE CASCADE
ON DELETE CASCADE,
ADD CONSTRAINT `fk_receipt_order_id`
FOREIGN KEY (`receipt_order_id`)
REFERENCES `orders`(`order_id`)
ON UPDATE CASCADE
ON DELETE CASCADE;

DELIMITER $$
CREATE TRIGGER insert_worker_after_user_insert
AFTER INSERT ON users
FOR EACH ROW
BEGIN
    IF (NEW.user_role_id = 2 OR NEW.user_role_id = 3) THEN
        INSERT INTO workers (worker_user_id) VALUES (NEW.user_id);
    END IF;
END$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER insert_image_after_user_or_product_insert
AFTER INSERT ON users
FOR EACH ROW
BEGIN
    INSERT INTO images (image_object_type, image_url, image_object_id)
    VALUES ('usuario', '/public/images/users/nf.jpg', NEW.user_id);
END$$

CREATE TRIGGER insert_image_after_product_insert
AFTER INSERT ON products
FOR EACH ROW
BEGIN
    INSERT INTO images (image_object_type, image_url, image_object_id)
    VALUES ('producto', '/public/images/products/nf.jpg', NEW.product_id);
END$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER update_worker_works_done
AFTER INSERT ON sold_products
FOR EACH ROW
BEGIN
    DECLARE seller_id INT;
    DECLARE num_sold INT;
    
    -- Obtener el ID del vendedor del producto vendido
    SELECT product_user_id INTO seller_id
    FROM products
    WHERE product_id = NEW.sold_product_product_id;
    
    -- Obtener el número de productos vendidos del vendedor
    SELECT COUNT(*) INTO num_sold
    FROM sold_products sp
    INNER JOIN products p ON sp.sold_product_product_id = p.product_id
    WHERE p.product_user_id = seller_id;
    
    -- Actualizar el número de productos vendidos en la tabla workers
    UPDATE workers
    SET worker_works_done = num_sold
    WHERE worker_user_id = seller_id;
END$$
DELIMITER ;
