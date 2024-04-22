<?php
// app/controllers/ProductController.php
require_once (__DIR__ . "/../models/database.php");
require_once (__DIR__ . "/../models/product.php");

class ProductController {

    public function showProducts() {

        include (__DIR__ . "/../views/products/products.view.php");
    }
    

}
