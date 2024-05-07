<?php
class PageController {
    private $productModel;
    private $userModel;
    private $cartModel;
    private $saleModel;

    public function __construct(mysqli $conn) { 
        $this -> productModel = new Product($conn);
        $this -> userModel = new User($conn);
        $this -> cartModel = new Cart();
        $this -> saleModel = new Sale($conn);
    }
    
    public function home(){
        require_once(__DIR__ . "/../views/home/home.view.php");
    }  

    public function products(){
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

        $products = $this -> productModel -> paginate($page, 5,  $queryRows, $query, "INNER JOIN users ON products.product_user_id = users.user_id");
        require_once(__DIR__ . "/../views/products/products.view.php");
    }
    public function login(){
        require_once(__DIR__ . "/../views/auth/login.view.php");
    }
    public function register(){
        require_once(__DIR__ . "/../views/auth/register.view.php");
    }

    public function user_cart() {
        $cart = $this -> cartModel -> getAll();
        require_once(__DIR__ . "/../views/profile/cart.view.php");
    }

    public function user_profile() {        

        $id = isset($_GET['id']) ? $_GET['id'] : $_SESSION['user_id'] ;
        $isAdmin = isset($_SESSION['user_role_id']) && $_SESSION['user_role_id'] == 3 || $_SESSION['user_id'] == $id ? true : false;
        if (!$isAdmin) {header('location: /'); exit();}

        $pageProducts = isset($_GET['pageProducts']) ? $_GET['pageProducts'] : 1;
        
        $user = $this -> userModel -> getById( $id );

        $products = $this -> productModel -> paginate($pageProducts, 5, "WHERE product_user_id = $id", "WHERE product_user_id = $id", "INNER JOIN categories ON products.product_category_id = categories.category_id");

        $pageSales = isset($_GET['pageSales']) ? $_GET['pageSales'] : 1;
        $sales = $this -> saleModel -> paginate($pageSales, 5, "WHERE sale_user_id = $id", "WHERE sale_user_id = $id");
        require_once(__DIR__. "/../views/profile/user.view.php");
    }

    public function product_profile() {
        $product = $this -> productModel -> getById( $_GET['id'] );
        $isAdmin = isset($_SESSION['user_role_id']) && $_SESSION['user_role_id'] == 3 || $_SESSION['user_id'] == $product['product_user_id'] ? true : false;
        if (!$isAdmin) {header('location: /'); exit();}

        require_once(__DIR__. "/../views/profile/product.view.php");
    }

    public function dashboard_users() {
        $isAdmin = isset($_SESSION['user_role_id']) && $_SESSION['user_role_id'] == 3 ? true : false;
        if (!$isAdmin) {header('location: /'); exit();}

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
        $isAdmin = isset($_SESSION['user_role_id']) && $_SESSION['user_role_id'] == 3 ? true : false;
        if (!$isAdmin) {header('location: /'); exit();}

        $page = isset($_GET['page']) ? $_GET['page'] : 1;        
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'product_id';

        $search = isset($_GET['search']) ? "WHERE (product_name LIKE '%".$_GET['search']."%' OR product_description LIKE '%".$_GET['search']."%' OR product_id LIKE '% ".$_GET['search']."%')" : "" ;

        $queryRows = "$search";
        $query = "$search ORDER BY $sort ASC";

        $products = $this->productModel->paginate($page, 5, $queryRows, $query, "INNER JOIN categories ON products.product_category_id = categories.category_id INNER JOIN users ON products.product_user_id = users.user_id");
        $user_session = $this->userModel->getById($_SESSION['user_id']);
        $users = $this->userModel->getAll();
        require_once(__DIR__ . "/../views/admin/dashboard_products.view.php");
    }

    public function recover_account () {
        require_once(__DIR__ . "/../views/auth/recover_account.view.php");
    }

    public function public_profile () {

        $vendedor_id = $_GET['vendedor'];
        $page = isset($_GET['page']) ? $_GET['page'] : 1;

        $user = $this -> userModel -> getById( $vendedor_id );

        $isAdmin = $user['user_role_id'] == 2 ? true : false;
        if (!$isAdmin) {header('location: /'); exit();}

        $products = $this -> productModel -> paginate($page, 2, "WHERE product_user_id = $vendedor_id", "WHERE product_user_id = $vendedor_id", "INNER JOIN users ON products.product_user_id = users.user_id");   
        $user = $products['data'][0];
        require_once(__DIR__ . "/../views/profile/public.view.php");
    }

    public function payprocess () {
        require_once(__DIR__ . "/../views/pay/form.view.php");
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