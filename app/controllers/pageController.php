<?php
class PageController {
    private $productModel;
    private $userModel;
    private $cartModel;
    private $saleModel;
    private $sellerModel;

    public function __construct(mysqli $conn) { 
        $this -> productModel = new Product($conn);
        $this -> userModel = new User($conn);
        $this -> cartModel = new Cart();
        $this -> saleModel = new Sale($conn);
        $this -> sellerModel = new Seller($conn);
    }
    
    public function home(){
        require_once(__DIR__ . "/../views/home/home.view.php");
    }  

    public function login(){
        require_once(__DIR__ . "/../views/auth/login.view.php");
    }
    public function register(){
        require_once(__DIR__ . "/../views/auth/register.view.php");
    }

    public function recover_account () {
        require_once(__DIR__ . "/../views/auth/recover_account.view.php");
    }
    
    public function payprocess () {
        require_once(__DIR__ . "/../views/pay/form.view.php");
    }

    public function user_cart() {
        $cart = $this -> cartModel -> getAll();
        require_once(__DIR__ . "/../views/profile/cart.view.php");
    }
    
    public function products(){
        // filtros y sorts
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $search = isset($_GET['search']) ? "(products.product_name LIKE '%".$_GET['search']."%' OR products.product_description LIKE '%".$_GET['search']."%') AND" : "" ;
        $addition = isset($_GET['filter']) && isset($_GET['value']) ? $_GET['filter']." = ".$_GET['value']." AND" : "";

        $min = isset($_GET['min']) ? $_GET['min'] : 0;
        $max = isset($_GET['max']) ? $_GET['max'] : 1000000000;
        $max_and_min = "product_price > $min AND product_price < $max";

        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'product_rating';
        $sortQuery = $sort == 'product_price' ? "ORDER BY $sort ASC " :  "ORDER BY $sort DESC" ;
        
        $queryRows = "WHERE $search $addition $max_and_min";
        $query = "WHERE $search $addition $max_and_min $sortQuery";

        $products = $this -> productModel -> paginate($page, 5,  $queryRows, $query, "INNER JOIN sellers ON products.product_seller_id = sellers.seller_id INNER JOIN users ON sellers.seller_user_id = users. user_id");
        require_once(__DIR__ . "/../views/products/products.view.php");
    }

    public function user_profile() {
        // Autenticación
        $id = isset($_GET['id']) ? $_GET['id'] : $_SESSION['user_id'] ;
        $isAdmin = $_SESSION['user_role_id'] == 4 || $_SESSION['user_id'] == $id ? true : false;
        if (!$isAdmin) {header('location: /'); exit();}

        // Inner join según el rol
        $inner_join_query = ' INNER JOIN roles ON users.user_role_id = roles.role_id ';
        $user = $this -> userModel -> getById($id, $inner_join_query);
        $inner_join_query .= $user['user_role_id'] == 2 ? 'INNER JOIN sellers ON users.user_id = sellers.seller_user_id' : ( $user['user_role_id'] == 3 ?  'INNER JOIN deliveries ON users.user_id = deliveries.delivery_user_id' : '');
        $user = $this -> userModel -> getById($id, $inner_join_query);

        // Compras del usuario
        $pageSales = isset($_GET['pageSales']) ? $_GET['pageSales'] : 1;
        $sales = $this -> saleModel -> paginate($pageSales, 5, "WHERE sale_user_id = $id", "WHERE sale_user_id = $id");

        // Productos si es vendedor
        if ($user['role_name'] == 'vendedor') {
            $pageProducts = isset($_GET['pageProducts']) ? $_GET['pageProducts'] : 1;
            $products = $this -> productModel -> paginate($pageProducts, 5, "WHERE product_seller_id = " . $user['seller_id'] , "WHERE product_seller_id = ". $user['seller_id'], "INNER JOIN categories ON products.product_category_id = categories.category_id");
        }
        
        require_once(__DIR__. "/../views/profile/user.view.php");
    }

    public function product_profile() {
        // producto
        $product = $this -> productModel -> getById( $_GET['id'] , "INNER JOIN sellers ON products.product_seller_id = sellers.seller_id");
        
        // Autenticación
        $isAdmin = $_SESSION['user_role_id'] == 4 || $_SESSION['user_id'] == $product['seller_user_id'] ? true : false;
        if (!$isAdmin) {header('location: /'); exit();}

        require_once(__DIR__. "/../views/profile/product.view.php");
    }

    public function dashboard_users() {
        // Autenticación
        $isAdmin = $_SESSION['user_role_id'] == 4 ? true : false;
        if (!$isAdmin) {header('location: /'); exit();}

        // Filtros y sorts
        $page = isset($_GET['page']) ? $_GET['page'] : 1; 
        $search = isset($_GET['search']) ? "WHERE (user_full_name LIKE '%".$_GET['search']."%' OR user_username LIKE '%".$_GET['search']."%' OR user_email LIKE '% ".$_GET['search']."%' OR user_id LIKE '% ".$_GET['search']."%')" : "" ;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'user_id';

        $queryRows = "$search";
        $query = "$search ORDER BY $sort ASC";
        $users = $this -> userModel -> paginate($page, 5, $queryRows, $query, "INNER JOIN roles ON users.user_role_id = roles.role_id");

        $user_sesion = $this -> userModel -> getById($_SESSION['user_id']);
        require_once(__DIR__ . "/../views/admin/dashboard_users.view.php");
    }
    
    public function dashboard_products() {
        // Autenticación
        $isAdmin = $_SESSION['user_role_id'] == 4 ? true : false;
        if (!$isAdmin) {header('location: /'); exit();}

        // Filtros y sorts
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $search = isset($_GET['search']) ? "WHERE (product_name LIKE '%".$_GET['search']."%' OR product_description LIKE '%".$_GET['search']."%' OR product_id LIKE '% ".$_GET['search']."%')" : "" ;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'product_id';

        $queryRows = "$search";
        $query = "$search ORDER BY $sort ASC";

        $products = $this->productModel->paginate($page, 5, $queryRows, $query, "INNER JOIN categories ON products.product_category_id = categories.category_id INNER JOIN sellers ON products.product_seller_id = sellers.seller_id INNER JOIN users ON sellers.seller_user_id = users. user_id");
        $user_session = $this->userModel->getById($_SESSION['user_id']);
        require_once(__DIR__ . "/../views/admin/dashboard_products.view.php");
    }

    public function public_profile () {
        // Vendedor        
        $seller_id = $_GET['vendedor'];
        $user = $this -> sellerModel -> getById( $seller_id , "INNER JOIN users ON sellers.seller_user_id = users.user_id INNER JOIN roles ON users.user_role_id = roles.role_id");
        
        // productos
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $products = $this -> productModel -> paginate($page, 2, "WHERE product_seller_id = $seller_id", "WHERE product_seller_id = $seller_id");   

        require_once(__DIR__ . "/../views/profile/public.view.php");
    }

    public function delivery_list () {
        $isAdmin = $_SESSION['user_role_id'] == 4 || $_SESSION['user_role_id'] == 3 ? true : false;
        if ($_SESSION['user_delivery']['state'] == 'inprocess') {
            header('location: /page/delivery/?id='. $_SESSION['user_delivery']['sale_id'] ); exit();
        }
        if (!$isAdmin) {header('location: /'); exit();}

        $deliveries = $this -> saleModel -> paginate(1, 1000 ,"WHERE sale_state = 'waiting'", "WHERE sale_state = 'waiting'", "INNER JOIN users ON sales.sale_user_id = users.user_id");
        require_once(__DIR__ . "/../views/delivery/list.view.php");
    }

    public function delivery () {
        $id = $_GET['id'];
        $_SESSION['user_delivery'] = ['state' => 'inprocess','sale_id'=> $id];
        $delivery = $this -> saleModel -> paginate(1, 1 ,"WHERE sale_id = '$id'", "WHERE sale_id = '$id'", "INNER JOIN users ON sales.sale_user_id = users.user_id")['data'][0];
        require_once(__DIR__ . "/../views/delivery/delivery.view.php");
    }

    public function sale_shift () {  
        $id = $_GET['id'];      
        $delivery = $this -> saleModel -> paginate(1, 1 ,"WHERE sale_id = '$id'", "WHERE sale_id = '$id'", "INNER JOIN users ON sales.sale_user_id = users.user_id")['data'][0];
        require_once(__DIR__ . "/../views/pay/shift.view.php");
    }
}