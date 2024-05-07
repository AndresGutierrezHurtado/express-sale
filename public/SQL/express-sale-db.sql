CREATE DATABASE `express-sale-db`;
USE `express-sale-db`;

-- --------------------------------------------------------
--
-- Create users table
CREATE TABLE `users` (
    `user_id` INT PRIMARY KEY AUTO_INCREMENT,
    `user_full_name` VARCHAR(100) NOT NULL,
    `user_username` VARCHAR(100) UNIQUE NOT NULL,
    `user_email` VARCHAR(100) UNIQUE NOT NULL,
    `user_description` TEXT, 
    `user_rating` DECIMAL(3, 2),
    `user_votes` INT DEFAULT 0,
    `user_sales_done` INT DEFAULT 0,
    `user_phone_number` DECIMAL(10),
    `user_address` VARCHAR(255),
    `user_image` VARCHAR(100),
    `user_password` TEXT NOT NULL,
    `user_role_id` INT NOT NULL
);

-- Insert data into users table
INSERT INTO `users` (`user_id`, `user_full_name`, `user_username`, `user_email`, `user_description`, `user_rating`, `user_votes`, `user_sales_done`, `user_phone_number`, `user_address`, `user_image`, `user_password`, `user_role_id`) VALUES
(1, 'Express Sale', 'Express_Sale', 'express_sale@gmail.com', NULL, NULL, 0, 0, 3209202177, 'Bogotá, Colombia', '/public/images/users/1.jpg', '1234', 3),
(2, 'Andrés Gutiérrez Hurtado', 'Andres_Gutierrez', 'andres52885241@gmail.com', 'Vendedor de productos variados.', 0.00, 0, 0, 3209202177, 'Dg. 68D Sur #70c-31, Bogotá, Colombia', '/public/images/users/2.jpg', '1234', 2),
(3, 'David Fernando Diaz Niausa', 'David_Diaz', 'davidfernandodiazniausa@gmail.com', 'Vendedor.', 0.00, 0, 0, 3214109557, 'Alfonso Lopez, Bogotá, Colombia', '/public/images/users/nf.jpg', '1234', 2),
(4, 'Jaider Harley Rondón Herrera', 'Jaider_Rondon', 'rondonjaider@gmail.com', 'Vendedor.', 0.00, 0, 0, 3112369205, 'Usme, Bogotá, Colombia', '/public/images/users/4.jpg', '1234', 2),
(5, 'Juan Sebastian Bernal Gamboa', 'Juan_Sebastian', 'juansebastianbernalgamboa@gmail.com', 'Vendedor.', 0.00, 0, 0, 3053964455, 'Usme, Bogotá, Colombia', '/public/images/users/nf.jpg', '1234', 2),
(6, 'Wendy Alejandra Navarro Arias', 'Wendy_Navarro', 'nwendy798@gmail.com', NULL, NULL, 0, 0, 3044462452, 'Kalamary V, Diagonal 69 Sur, Bogotá, Colombia', '/public/images/users/6.jpg', '1234', 1),
(7, 'Santiago Hurtado Medina', 'Santiago_Hurtado', 'shurtado@gmail.com', NULL, NULL, 0, 0, 3208878515, 'Molinos del sur, Diagonal 49f Bis Sur, Bogotá, Colombia', '/public/images/users/7.jpg', '1234', 4);

-- --------------------------------------------------------
--
-- Create products table
CREATE TABLE `products` (
    `product_id` INT PRIMARY KEY AUTO_INCREMENT,
    `product_name` VARCHAR(100) NOT NULL,
    `product_description` TEXT,
    `product_price` DECIMAL(10, 2) NOT NULL,
    `product_stock` INT NOT NULL,
    `product_image` VARCHAR(100),
    `product_rating` DECIMAL(3, 2),
    `product_votes` INT DEFAULT 0,
    `product_category_id` INT,
    `product_user_id` INT, 
    `product_date` DATE,
    `product_state` ENUM('public', 'private') DEFAULT 'public'
);

-- Insert data into products table
INSERT INTO `products` (`product_id`, `product_name`, `product_description`, `product_price`, `product_stock`, `product_image`, `product_rating`, `product_votes`, `product_category_id`, `product_user_id`, `product_date`, `product_state`) VALUES
(1, 'Nike Air Jordan 1', 'Las icónicas zapatillas Nike Air Jordan 1 son un clásico atemporal en el mundo de la moda urbana, conocidas por su estilo y comodidad.', 289900.00, 1, '/public/images/products/1.jpg', 0.00, 0, 1, 3, '2024-01-15', 'public'),
(2, 'Cadena Cubana de Plata', 'Una cadena cubana de plata es un accesorio clásico y llamativo que puede complementar cualquier atuendo, ya sea casual o más elegante.', 24900.00, 4, '/public/images/products/2.jpg', 0.00, 0, 1, 3, '2024-02-20', 'public'),
(3, 'Casio G-Shock GA-2100', 'El reloj Casio G-Shock GA-2100 es conocido por su resistencia y estilo, con características como resistencia a golpes, al agua y un diseño moderno y elegante.', 224000.00, 3, '/public/images/products/3.jpg', 0.00, 0, 1, 3, '2024-03-05', 'public'),
(4, 'iPhone 13 Pro', 'El iPhone 13 Pro es el último modelo de Apple que combina un diseño elegante con un rendimiento potente y cámaras avanzadas para capturar imágenes impresionantes.', 2100000.00, 4, '/public/images/products/4.jpg', 0.00, 0, 3, 4, '2024-04-10', 'public'),
(5, 'Xbox Series X', 'La Xbox Series X ofrece potencia de próxima generación, velocidades de carga ultrarrápidas y una amplia biblioteca de juegos para una experiencia de juego inigualable.', 3599900.00, -1, '/public/images/products/5.jpg', 0.00, 0, 3, 4, '2024-01-25', 'public'),
(6, 'PlayStation 5', 'La PlayStation 5 es la consola de última generación de Sony, que ofrece gráficos impresionantes, carga ultrarrápida y una amplia variedad de juegos exclusivos.', 4599900.00, 1, '/public/images/products/6.jpg', 0.00, 0, 3, 4, '2024-02-05', 'public'),
(7, 'Galletas Oreo', 'Las deliciosas galletas Oreo, con su crujiente galleta y su cremoso relleno de vainilla, son un clásico de la merienda que gusta a niños y adultos por igual.', 26900.00, 40, '/public/images/products/7.jpg', 0.00, 0, 2, 5, '2024-03-15', 'public'),
(8, 'Nutella', 'La crema de avellanas Nutella, con su textura suave y su sabor dulce, es un imprescindible en el desayuno de millones de personas en todo el mundo.', 7000.00, 22, '/public/images/products/8.jpg', 0.00, 0, 2, 5, '2024-04-20', 'public'),
(9, 'KitKat', 'El delicioso chocolate KitKat, con sus característicos barquillos y su irresistible sabor, es el snack perfecto para disfrutar en cualquier momento del día.', 4000.00, 28, '/public/images/products/9.jpg', 0.00, 0, 2, 5, '2024-01-30', 'public'),
(10, 'Mancuernas Ajustables', 'Un par de mancuernas ajustables con diferentes pesos, perfectas para entrenamiento de fuerza en casa o en el gimnasio.', 89900.00, 8, '/public/images/products/10.jpg', 0.00, 0, 4, 2, '2024-02-10', 'public'),
(11, 'Megaplex | Creatine Power', 'Suplemento de proteína en polvo de alta calidad, ideal para la recuperación muscular y el crecimiento después del entrenamiento.', 59900.00, 10, '/public/images/products/11.jpg', 0.00, 0, 4, 2, '2024-03-20', 'public'),
(12, 'Rubik`s Cube', 'El clásico cubo de Rubik, con su diseño de colores vivos y su desafiante mecánica, es uno de los rompecabezas más populares y reconocidos del mundo.', 15000.00, 15, '/public/images/products/12.jpg', 0.00, 0, 4, 2, '2024-04-27', 'public');

-- --------------------------------------------------------
--
-- Create roles table
CREATE TABLE `roles` (
    `role_id` INT PRIMARY KEY AUTO_INCREMENT,
    `role_name` VARCHAR(50) NOT NULL
);

-- Insert predefined roles
INSERT INTO `roles` (`role_id`, `role_name`) VALUES 
(1, 'usuario'),
(2, 'vendedor'),
(3, 'administrador'),
(4, 'domiciliario');

-- --------------------------------------------------------
--
-- Create categories table
CREATE TABLE `categories` (
    `category_id` INT PRIMARY KEY AUTO_INCREMENT,
    `category_name` VARCHAR(50) NOT NULL
);

-- Insert predefined categories
INSERT INTO `categories` (`category_id`, `category_name`) VALUES 
(1, 'moda'),
(2, 'comida'),
(3, 'tecnologia'),
(4, 'otros');

-- --------------------------------------------------------
--
-- Create sales table
CREATE TABLE `sales` (
    `sale_id` INT PRIMARY KEY AUTO_INCREMENT,
    `sale_user_id` INT,
    `sale_description` TEXT,
    `sale_message` TEXT,
    `sale_full_name` VARCHAR(100),
    `sale_email` VARCHAR(100),
    `sale_phone_number` VARCHAR(20),
    `sale_address` VARCHAR(255),
    `sale_coords` VARCHAR(255),
    `sale_price` DECIMAL(9, 2),
    `sale_state` ENUM('Espera', 'Envío', 'Llegó') DEFAULT 'Espera',
    `sale_date` DATE
);

-- --------------------------------------------------------
--
-- Add foreign keys
ALTER TABLE `users` 
ADD FOREIGN KEY (`user_role_id`) 
REFERENCES `roles`(`role_id`)
ON UPDATE CASCADE
ON DELETE CASCADE;

ALTER TABLE `products` 
ADD FOREIGN KEY (`product_user_id`) 
REFERENCES `users`(`user_id`)
ON UPDATE CASCADE
ON DELETE CASCADE;

ALTER TABLE `products` 
ADD FOREIGN KEY (`product_category_id`) 
REFERENCES `categories`(`category_id`)
ON UPDATE CASCADE
ON DELETE CASCADE;


ALTER TABLE `sales`
ADD FOREIGN KEY (`sale_user_id`) 
REFERENCES `users`(`user_id`)
ON UPDATE CASCADE
ON DELETE CASCADE;

-- --------------------------------------------------------
--
-- Add triggers
DELIMITER $$

CREATE TRIGGER after_insert_sale
AFTER INSERT ON sales
FOR EACH ROW
BEGIN
    DECLARE product_id INT;
    DECLARE quantity_sold INT;
    DECLARE seller_id INT;
    DECLARE total_products INT; 

    SET total_products = JSON_LENGTH(NEW.sale_description); 

    SET @i = 0;
    WHILE @i < total_products DO 
        -- Get product id, quantity sold, and seller id
        SET product_id = JSON_UNQUOTE(JSON_EXTRACT(NEW.sale_description, CONCAT('$[', @i, '].product_id')));
        SET quantity_sold = JSON_UNQUOTE(JSON_EXTRACT(NEW.sale_description, CONCAT('$[', @i, '].product_quantity')));
        SET seller_id = JSON_UNQUOTE(JSON_EXTRACT(NEW.sale_description, CONCAT('$[', @i, '].user_id')));

        -- Check if product id is not null
        IF product_id IS NOT NULL THEN
            UPDATE products SET product_stock = product_stock - quantity_sold WHERE product_id = product_id;
            UPDATE users SET user_sales_done = user_sales_done + 1 WHERE user_id = seller_id;
        END IF;

        SET @i = @i + 1;
    END WHILE;
END$$

DELIMITER ;
