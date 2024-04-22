<?php
class PageController {
    private $conn;
    public function __construct(mysqli $conn) { 
        $this->conn = $conn;
    }
    
    public function home(){
        require_once(__DIR__ . "/../views/home/home.view.php");
    }  
    public function products(){
        $productModel = new Product($this ->conn);
        $products = $productModel ->getAll();
        
        require_once(__DIR__ . "/../views/products/products.view.php");
    }
    public function login(){
        require_once(__DIR__ . "/../views/auth/login.view.php");
    }
    public function register(){
        require_once(__DIR__ . "/../views/auth/register.view.php");
    }
}