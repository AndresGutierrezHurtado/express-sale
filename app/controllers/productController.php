<?php
// app/controllers/ProductController.php
require_once (__DIR__ . "/../models/database.php");
require_once (__DIR__ . "/../models/product.php");

class ProductController {

    public function showProducts() {
        $database = new Database();
        $productModel = new Product($database);
        $products = $productModel->showProducts();
        return $products;
    }
}

