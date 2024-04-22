CREATE DATABASE `express_sale_db`;
USE `express_sale_db`;

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

-- Create products table
CREATE TABLE `products` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `description` TEXT,
    `price` DECIMAL(10, 2) NOT NULL,
    `stock` INT NOT NULL,
    `image` VARCHAR(100),
    `category_id` INT
);

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
INSERT INTO `categories` (`name`) VALUES 
('moda'), 
('comida'), 
('otros');

-- Add foreign keys
ALTER TABLE `users` 
ADD FOREIGN KEY (`role_id`) 
REFERENCES `roles`(`id`);

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
