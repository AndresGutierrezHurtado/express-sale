<?php
// /app/controllers/productController.php
require_once (__DIR__ . "/../models/product.php");

class ProductController {

    private $productModel;

    public function __construct(PDO $conn) {
        $this->productModel = new Product($conn);
    }

    public function index() {
        $products = $this -> productModel -> getAll();
    }

}

