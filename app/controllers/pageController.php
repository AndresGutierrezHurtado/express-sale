<?php
session_start();
class PageController {
    private $productModel;
    private $userModel;
    public function __construct(mysqli $conn) { 
        $this -> productModel = new Product($conn);
        $this -> userModel = new User($conn);
    }
    
    public function home(){
        require_once(__DIR__ . "/../views/home/home.view.php");
    }  
    public function products(){
        $products = $this ->productModel ->getAll();        
        require_once(__DIR__ . "/../views/products/products.view.php");
    }
    public function login(){
        require_once(__DIR__ . "/../views/auth/login.view.php");
    }
    public function register(){
        require_once(__DIR__ . "/../views/auth/register.view.php");
    }

    public function user_profile() {
        $user = $this -> userModel -> getById($_GET['id']);
        require_once(__DIR__. "/../views/profile/user.php");
    }

    public function dashboard_users() {
        $users = $this -> userModel -> paginate(1, 2);
        $user_sesion = $this -> userModel -> getById($_SESSION['user_id']);
        require_once(__DIR__ . "/../views/admin/dashboard_users.view.php");
    }
    
    public function dashboard_products() {
        $products = $this -> productModel -> paginate(1, 2);
        $user_sesion = $this -> userModel -> getById($_SESSION['user_id']);
        require_once(__DIR__ . "/../views/admin/dashboard_products.view.php");
    }
}