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
        $users = $this -> userModel -> getAll();
        $page = isset($_GET['page']) ? $_GET['page'] : 1;

        if (isset( $_GET['search'])) {
            $search = $_GET['search'];
            $products = $this -> productModel -> getBySearch($page, 5, $search);
                        
        } else if (isset($_GET['filter']) && $_GET['filter'] == 'category_id' ) {
            $products = $this -> productModel -> getByFilter($page, 5, $_GET['filter'], $_GET['value']);

        } else if (isset($_GET['filter']) && $_GET['filter'] == 'price') {
            $min = ($_GET['min'] != '') ? $_GET['min'] : 0 ;
            $max = ($_GET['max'] != '') ? $_GET['max'] : 0 ;
            $products = $this -> productModel -> getByPrice($page, 5, $_GET['filter'], $min, $max);

        } else{
            $sort = isset($_GET['sort']) ? $_GET['sort'] : 'calification';
            $products = $this -> productModel -> paginate($page, 5, $sort);

        }
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
        $products = $this -> productModel -> getByFilter($page, 5, 'user_id', $id);
        require_once(__DIR__. "/../views/profile/user.view.php");
    }

    public function user_cart() {
        require_once(__DIR__ . "/../views/profile/cart.view.php");
    }

    public function product_profile() {
        $product = $this -> productModel -> getById( $_GET['id'] );
        require_once(__DIR__. "/../views/profile/product.view.php");
    }

    public function dashboard_users() {
        $page = isset($_GET['page']) ? $_GET['page'] : 1; 
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'user_id';
        $users = $this -> userModel -> paginate($page, 5, $sort);
        $user_sesion = $this -> userModel -> getById($_SESSION['user_id']);
        require_once(__DIR__ . "/../views/admin/dashboard_users.view.php");
    }
    
    public function dashboard_products() {
        $page = isset($_GET['page']) ? $_GET['page'] : 1; 
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'id';
        $products = $this -> productModel -> paginate($page, 5, $sort);
        $user_sesion = $this -> userModel -> getById($_SESSION['user_id']);
        $users = $this -> userModel -> getAll();
        require_once(__DIR__ . "/../views/admin/dashboard_products.view.php");
    }
}