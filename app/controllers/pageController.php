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
        $page = isset($_GET['page']) ? $_GET['page'] : 1; 
        $products = $this -> productModel -> paginate($page, 5);      
        require_once(__DIR__ . "/../views/products/products.view.php");
    }
    public function login(){
        require_once(__DIR__ . "/../views/auth/login.view.php");
    }
    public function register(){
        require_once(__DIR__ . "/../views/auth/register.view.php");
    }

    public function user_profile() {
        $id = isset($_GET['id']) ? $_GET['id'] : $_SESSION['user_id'] ; 
        $user = $this -> userModel -> getById( $id );
        $page = isset($_GET['page']) ? $_GET['page'] : 1; 
        $products = $this -> productModel -> getBySeller($page, 5, $id);
        require_once(__DIR__. "/../views/profile/user.view.php");
    }

    public function product_profile() {
        $product = $this -> productModel -> getById( $_GET['id'] );
        require_once(__DIR__. "/../views/profile/product.view.php");
    }

    public function dashboard_users() {
        $page = isset($_GET['page']) ? $_GET['page'] : 1; 
        $users = $this -> userModel -> paginate($page, 5);
        $user_sesion = $this -> userModel -> getById($_SESSION['user_id']);
        require_once(__DIR__ . "/../views/admin/dashboard_users.view.php");
    }
    
    public function dashboard_products() {
        $page = isset($_GET['page']) ? $_GET['page'] : 1; 
        $products = $this -> productModel -> paginate($page, 5);
        $user_sesion = $this -> userModel -> getById($_SESSION['user_id']);
        require_once(__DIR__ . "/../views/admin/dashboard_products.view.php");
    }
}