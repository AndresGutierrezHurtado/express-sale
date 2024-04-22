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
    ('iPhone 13', 'The iPhone 13 features a stunning Super Retina XDR display, A15 Bionic chip, advanced dual-camera system, and all-day battery life. Get your hands on the latest iPhone today!', 999.99, 50, '/public/images/products/nf.jpg', 3, 4.5, 1, 'public'),
    ('Samsung Galaxy S22', 'Experience the power and performance of the Samsung Galaxy S22. With its cutting-edge camera technology, fast-charging battery, and sleek design, the Galaxy S22 is the perfect companion for your daily adventures.', 899.99, 100, '/public/images/products/nf.jpg', 3, 4.7, 2, 'public'), 
    ('Sony WH-1000XM4 Headphones', 'Immerse yourself in music like never before with the Sony WH-1000XM4 headphones. Featuring industry-leading noise cancellation, high-resolution audio, and all-day comfort, these headphones redefine the listening experience.', 349.99, 30, '/public/images/products/nf.jpg', 3, 4.8, 3, 'public'),
    ('Fitbit Charge 5', 'Track your health and fitness goals with the Fitbit Charge 5. With built-in GPS, heart rate monitoring, sleep tracking, and a sleek design, the Charge 5 helps you stay motivated and on track every day.', 179.99, 20, '/public/images/products/nf.jpg', 4, 4.3, 4, 'public'), 
    ('Canon EOS R5', 'Unleash your creativity with the Canon EOS R5. This full-frame mirrorless camera features 8K video recording, advanced autofocus, and stunning image quality, making it the perfect tool for professional photographers and videographers.', 3799.99, 10, '/public/images/products/nf.jpg', 3, 4.9, 5, 'public'); 

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
INSERT INTO `account_types` (`type_name`) VALUES 
('standard'), 
('premium');

-- Create roles table
CREATE TABLE `roles` (
    `id` INT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL
);

-- Insert predefined roles
INSERT INTO `roles` (`id`, `name`) VALUES 
(1, 'cliente'), 
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
FOREIGN KEY (`user_id`) 
REFERENCES `users`(`user_id`)

ALTER TABLE `products` 
ADD FOREIGN KEY (`category_id`) 
REFERENCES `categories`(`id`);

ALTER TABLE `sales` 
ADD FOREIGN KEY (`user_id`) 
REFERENCES `users`(`user_id`);

-- Add foreign keys
ALTER TABLE `users`
ADD FOREIGN KEY (`account_type`) 
REFERENCES `account_types`(`id`);
