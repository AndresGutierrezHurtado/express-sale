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

        $search = isset($_GET['search']) ? "(name LIKE '%".$_GET['search']."%' OR description LIKE '%".$_GET['search']."%') AND" : "" ;

        $addition = isset($_GET['filter']) && isset($_GET['value']) ? $_GET['filter']." = ".$_GET['value']." AND" : "";

        $min = isset($_GET['min']) ? $_GET['min'] : 0;
        $max = isset($_GET['max']) ? $_GET['max'] : 1000000000;
        $max_and_min = "price > $min AND price < $max";

        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'calification';
        
        $queryRows = "WHERE $search $addition $max_and_min";
        $query = "WHERE $search $addition $max_and_min  ORDER BY $sort ASC";

        $products = $this -> productModel -> paginate($page, 5,  $queryRows, $query);
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
        $isAdmin = isset($_SESSION['role_id']) && $_SESSION['role_id'] == 3 || $_SESSION['user_id'] == $id ? true : false;
        if (!$isAdmin) {header('location: /'); exit();}

        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        
        $user = $this -> userModel -> getById( $id );

        $products = $this -> productModel -> paginate($page, 5, "WHERE user_id = $id", "WHERE user_id = $id");
        require_once(__DIR__. "/../views/profile/user.view.php");
    }

    public function user_cart() {
        require_once(__DIR__ . "/../views/profile/cart.view.php");
    }

    public function product_profile() {
        $product = $this -> productModel -> getById( $_GET['id'] );
        $isAdmin = isset($_SESSION['role_id']) && $_SESSION['role_id'] == 3 || $_SESSION['user_id'] == $product -> user_id ? true : false;
        if (!$isAdmin) {header('location: /'); exit();}

        require_once(__DIR__. "/../views/profile/product.view.php");
    }

    public function dashboard_users() {
        $isAdmin = isset($_SESSION['role_id']) && $_SESSION['role_id'] == 3 ? true : false;
        if (!$isAdmin) {header('location: /'); exit();}

        $page = isset($_GET['page']) ? $_GET['page'] : 1; 

        $search = isset($_GET['search']) ? "WHERE (full_name LIKE '%".$_GET['search']."%' OR username LIKE '%".$_GET['search']."%' OR email LIKE '% ".$_GET['search']."%' OR user_id LIKE '% ".$_GET['search']."%')" : "" ;

        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'user_id';

        $queryRows = "$search";
        $query = "$search ORDER BY $sort ASC";

        $users = $this -> userModel -> paginate($page, 5, $queryRows, $query);

        $user_sesion = $this -> userModel -> getById($_SESSION['user_id']);
        require_once(__DIR__ . "/../views/admin/dashboard_users.view.php");
    }
    
    public function dashboard_products() {
        $isAdmin = isset($_SESSION['role_id']) && $_SESSION['role_id'] == 3 ? true : false;
        if (!$isAdmin) {header('location: /'); exit();}

        $page = isset($_GET['page']) ? $_GET['page'] : 1;        
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'id';

        $products = $this -> productModel -> paginate($page, 5, "", "ORDER BY $sort ASC");
        $user_sesion = $this -> userModel -> getById($_SESSION['user_id']);
        $users = $this -> userModel -> getAll();
        require_once(__DIR__ . "/../views/admin/dashboard_products.view.php");
    }
}