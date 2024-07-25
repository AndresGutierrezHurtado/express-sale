<?php
class PageController {
    
    private $productModel;
    private $userModel;
    private $cartModel;
    private $orderModel;
    private $soldProductModel;
    private $calificationModel;

    public function __construct(mysqli $conn) { 
        $this -> productModel = new Product($conn);
        $this -> userModel = new User($conn);
        $this -> cartModel = new Cart();
        $this -> orderModel = new Order($conn);
        $this -> soldProductModel = new soldProduct($conn);
        $this -> calificationModel = new calification( $conn);
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
        // $search = isset($_GET['search']) ? "(producto_nombre LIKE '%".$_GET['search']."%' OR producto_descripcion LIKE '%".$_GET['search']."%' OR usuarios.usuario_alias LIKE '%".$_GET['search']."%') AND" : "" ;
        // $addition = isset($_GET['filter']) && isset($_GET['value']) ? $_GET['filter']." = ".$_GET['value']." AND" : "";

        // $min = isset($_GET['min']) ? $_GET['min'] : 0;
        // $max = isset($_GET['max']) ? $_GET['max'] : 1000000000;
        // $max_and_min = "producto_precio > $min AND producto_precio < $max";

        // $sort = isset($_GET['sort']) ? $_GET['sort'] : 'avg_calification';
        // $sortQuery = $sort == 'producto_precio' ? "ORDER BY $sort ASC " :  "ORDER BY $sort DESC" ;
        
        // $select = "*, ROUND(AVG(calificaciones.calification), 2) AS avg_calification, 
        // (SELECT COUNT(*) FROM califications WHERE califications.calificated_object_id = products.product_id AND califications.calification_object_type = 'producto') AS califications_count";

        $inner_join = "
        INNER JOIN categorias ON productos.categoria_id = categorias.categoria_id
        INNER JOIN usuarios ON productos.usuario_id = usuarios.usuario_id
        ";

        // $queryRows = "WHERE $search $addition $max_and_min";
        // $query = "WHERE $search $addition $max_and_min GROUP BY products.product_id $sortQuery ";

        $products = $this -> productModel -> paginate($page, 5, "*", $inner_join, "", "");
        
        require_once(__DIR__ . "/../views/products/products.view.php");
    }

    public function public_profile () {
        // Vendedor
        $selectUser =  "*, 
        ROUND(AVG(califications.calification), 2) AS avg_calification,
        (SELECT COUNT(*) FROM califications WHERE califications.calificated_object_id = users.user_id AND califications.calification_object_type = 'usuario' AND califications.calification = 1) as num_calification_1,
        (SELECT COUNT(*) FROM califications WHERE califications.calificated_object_id = users.user_id AND califications.calification_object_type = 'usuario' AND califications.calification = 2) as num_calification_2,
        (SELECT COUNT(*) FROM califications WHERE califications.calificated_object_id = users.user_id AND califications.calification_object_type = 'usuario' AND califications.calification = 3) as num_calification_3,
        (SELECT COUNT(*) FROM califications WHERE califications.calificated_object_id = users.user_id AND califications.calification_object_type = 'usuario' AND califications.calification = 4) as num_calification_4,
        (SELECT COUNT(*) FROM califications WHERE califications.calificated_object_id = users.user_id AND califications.calification_object_type = 'usuario' AND califications.calification = 5) as num_calification_5,
        (SELECT COUNT(*) FROM califications WHERE califications.calificated_object_id = users.user_id AND califications.calification_object_type = 'usuario') AS califications_count";

        $inner_join_users = " INNER JOIN images ON users.user_id = images.image_object_id AND images.image_object_type = 'usuario'
        INNER JOIN workers ON users.user_id = workers.worker_user_id
        LEFT JOIN califications ON users.user_id = califications.calificated_object_id AND califications.calification_object_type = 'usuario' ";

        $user = $this -> userModel -> getById($_GET['usuario'], $selectUser, $inner_join_users);
        $user_id = $user['user_id'];

        $califications = $this -> calificationModel -> getAll("*", 
        "INNER JOIN users ON califications.calificator_user_id = users.user_id
        INNER JOIN images ON users.user_id = images.image_object_id AND images.image_object_type = 'usuario'", 
        "WHERE califications.calification_object_type = 'usuario' AND califications.calificated_object_id = " . $user_id );
        
        // productos
        $selectProducts = "*, ROUND(AVG(califications.calification), 2) AS avg_calification, 
        (SELECT COUNT(*) FROM califications WHERE califications.calificated_object_id = products.product_id AND califications.calification_object_type = 'producto') AS califications_count";
        
        $inner_join_products = "
        INNER JOIN categories ON products.product_category_id = categories.category_id
        INNER JOIN states ON products.product_state_id = states.state_id
        INNER JOIN images ON products.product_id = images.image_object_id AND images.image_object_type = 'producto'
        LEFT JOIN califications ON products.product_id = califications.calificated_object_id AND califications.calification_object_type = 'producto'
        ";

        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $products = $this -> productModel -> paginate($page, 2, $selectProducts, $inner_join_products, "WHERE product_user_id = ".$user_id , "WHERE product_user_id = ".$user_id. " GROUP BY products.product_id ORDER BY avg_calification DESC");   


        require_once(__DIR__ . "/../views/profile/public.view.php");
    }

    public function user_profile() {
        // Autenticación
        $id = isset($_GET['id']) ? $_GET['id'] : $_SESSION['user_id'] ;
        $isAdmin = $_SESSION['user_role_id'] == 4 || $_SESSION['user_id'] == $id ? true : false;
        if (!$isAdmin) {header('location: /'); exit();}

        // usuario
        $inner_join = "INNER JOIN roles ON users.user_role_id = roles.role_id
        INNER JOIN images ON users.user_id = images.image_object_id AND images.image_object_type = 'usuario'
        LEFT JOIN workers ON users.user_id = workers.worker_user_id 
        ";
        $products_page = isset($_GET["products_page"]) ? $_GET["products_page"] : 1;
        $user = $this -> userModel -> getById($id, "*", $inner_join);

        // orders
        $orders_inner_join = "INNER JOIN states ON orders.order_state_id = states.state_id
        INNER JOIN sold_products ON sold_products.sold_product_order_id = orders.order_id
        INNER JOIN products ON sold_products.sold_product_product_id = products.product_id ";

        $deliveries = $this -> orderModel -> getAll("*", $orders_inner_join, "WHERE orders.order_user_id = $id");

        $orders = [];

        foreach ($deliveries as $order) {
            $order_id = $order['order_id'];

            if (!array_key_exists($order_id, $orders)) {
                $orders[$order_id] = array(
                    'order_id' => $order['order_id'],
                    'order_date' => $order['order_date'],
                    'order_first_name' => $order['order_first_name'],
                    'order_last_name' => $order['order_last_name'],
                    'order_address' => $order['order_address'],
                    'order_coords' => $order['order_coords'],
                    'order_user_id' => $order['order_user_id'],
                    'order_amount' => $order['order_amount'],
                    'state_name' => $order['state_name'],
                    'products' => array()
                );
            }
        
            $orders[$order_id]['products'][] = array(
                'sold_product_id' => $order['sold_product_id'],
                'sold_product_quantity' => $order['sold_product_quantity'],
                'sold_product_address' => $order['sold_product_address'],
                'product_name'=> $order['product_name']
            );
        }

        $deliveries['rows'] = count($orders);

        // productos
        if ($user['role_name'] == 'vendedor') {
            $products = $this -> productModel -> paginate($products_page, 5, '*', "INNER JOIN categories ON products.product_category_id = categories.category_id", "WHERE product_user_id = $id", "WHERE product_user_id = $id");
        }
        
        require_once(__DIR__. "/../views/profile/user.view.php");
    }

    public function product_profile() {
        // obtener datos del producto
        $product = $this -> productModel -> getById( $_GET['id'] , "*", "INNER JOIN users ON products.product_user_id = users.user_id 
        INNER JOIN images ON products.product_id = images.image_object_id AND images.image_object_type = 'producto'");
        
        // Autenticación
        $isAdmin = $_SESSION['user_role_id'] == 4 || $_SESSION['user_id'] == $product['product_user_id'] ? true : false;
        if (!$isAdmin) {header('location: /'); exit();}

        require_once(__DIR__. "/../views/profile/product.view.php");
    }

    public function dashboard_users() {
        // Autenticación
        $isAdmin = $_SESSION['user_role_id'] == 4 ? true : false;
        if (!$isAdmin) {header('location: /'); exit();}

        // Filtros y sorts para obtener los usuarios
        $page = isset($_GET['page']) ? $_GET['page'] : 1; 
        $search = isset($_GET['search']) ? "WHERE 
        (user_first_name LIKE '%".$_GET['search']."%' OR 
        role_name LIKE '%".$_GET['search']."%' OR 
        user_first_name LIKE '%".$_GET['search']."%' OR 
        user_last_name LIKE '%".$_GET['search']."%' OR 
        user_username LIKE '%".$_GET['search']."%' OR 
        user_email LIKE '%".$_GET['search']."%' OR 
        user_id LIKE '%".$_GET['search']."%')" : "" ;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'user_id';

        $queryRows = "$search";
        $query = "$search ORDER BY $sort ASC";
        $users = $this -> userModel -> paginate($page, 5, "*", "INNER JOIN roles ON users.user_role_id = roles.role_id", $queryRows, $query);

        $user_session = $this -> userModel -> getById($_SESSION['user_id'], "*", "INNER JOIN images ON users.user_id = images.image_object_id AND images.image_object_type = 'usuario'");
        require_once(__DIR__ . "/../views/admin/dashboard_users.view.php");
    }
    
    public function dashboard_products() {
        // Autenticación
        $isAdmin = $_SESSION['user_role_id'] == 4 ? true : false;
        if (!$isAdmin) {header('location: /'); exit();}

        // Filtros y sorts para obtener los productos
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $search = isset($_GET['search']) ? "WHERE 
        (product_name LIKE '%".$_GET['search']."%' OR 
        product_description LIKE '%".$_GET['search']."%' OR 
        category_name LIKE '%".$_GET['search']."%' OR 
        user_username LIKE '%".$_GET['search']."%' OR 
        product_id LIKE '% ".$_GET['search']."%')" : "" ;

        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'product_id';

        $queryRows = "$search";
        $query = "$search ORDER BY $sort ASC";
        $inner_join = "INNER JOIN categories ON products.product_category_id = categories.category_id 
        INNER JOIN users ON products.product_user_id = users.user_id";

        $products = $this -> productModel -> paginate($page, 5, "*", $inner_join, $queryRows, $query);
        
        $user_session = $this -> userModel -> getById($_SESSION['user_id'], "*", "INNER JOIN images ON users.user_id = images.image_object_id AND images.image_object_type = 'usuario'");
        require_once(__DIR__ . "/../views/admin/dashboard_products.view.php");
    }

    public function delivery_list () {
        // autenticación
        if ($_SESSION['user_delivery']['state'] == 'busy') { header('location: /page/delivery/?id='. $_SESSION['user_delivery']['order_id'] ); exit(); }
        $isAdmin = $_SESSION['user_role_id'] == 4 || $_SESSION['user_role_id'] == 3 ? true : false;
        if (!$isAdmin) {header('location: /'); exit();}
        
        // obtener las ordenes pendientes
        $select_deliveries = "
        orders.*,
        sold_products.*";

        $inner_join_deliveries = " INNER JOIN sold_products ON sold_products.sold_product_order_id = orders.order_id
        INNER JOIN products ON sold_products.sold_product_product_id = products.product_id";

        $deliveries = $this -> orderModel -> getAll($select_deliveries, $inner_join_deliveries, "WHERE order_state_id = 3 ORDER BY orders.order_date");

        // agrupar las ordenes con sus productos
        $orders = [];

        foreach ($deliveries as $order) { 
            $order_id = $order['order_id'];
            if (!array_key_exists($order_id, $orders)) {
                // Si la orden no existe, crear una nueva entrada en el arreglo para ella
                $orders[$order_id] = array(
                    'order_id' => $order['order_id'],
                    'order_date' => $order['order_date'],
                    'order_first_name' => $order['order_first_name'],
                    'order_last_name' => $order['order_last_name'],
                    'order_address' => $order['order_address'],
                    'order_coords' => $order['order_coords'],
                    'order_user_id' => $order['order_user_id'],
                    'products' => array()
                );
            }
        
            $orders[$order_id]['products'][] = array(
                'sold_product_id' => $order['sold_product_id'],
                'sold_product_address' => $order['sold_product_address']
            );
        }
        
        require_once(__DIR__ . "/../views/delivery/list.view.php");
    }

    public function delivery () {
        $id = $_GET['id'];
        // actualizar al domiciliario y su orden
        $_SESSION['user_delivery'] = ['state' => 'busy','order_id'=> $id];
        $worker = $this -> userModel -> getById($_SESSION['user_id'], "*", "INNER JOIN workers ON users.user_id = workers.worker_user_id");
        $this -> orderModel -> updateById($id, ['order_worker_id' => $worker['worker_id']]);
        
        // obtener detalles de la orden
        $inner_join_orders = "INNER JOIN users ON orders.order_user_id = users.user_id
        INNER JOIN states ON orders.order_state_id = states.state_id";
        $order = $this -> orderModel -> getById($id, "*", $inner_join_orders);
        
        // obtener productos de la orden
        $inner_join_products = "INNER JOIN products ON sold_products.sold_product_product_id = products.product_id 
        INNER JOIN images ON products.product_id = images.image_object_id AND images.image_object_type = 'producto'";

        $products = $this -> soldProductModel -> getAll("*", $inner_join_products, "WHERE sold_product_order_id = $id");

        require_once(__DIR__ . "/../views/delivery/delivery.view.php");
    }

    public function order_shift () {
        $id = $_GET['id'];
        // obtener orden
        $inner_join_orders = "INNER JOIN users ON orders.order_user_id = users.user_id
        INNER JOIN states ON orders.order_state_id = states.state_id";

        $delivery = $this -> orderModel -> getById($id, "*", $inner_join_orders);

        // obtener domiciliario
        $worker = isset($delivery['order_worker_id']) ? $this -> userModel -> getAll("*", "INNER JOIN workers ON users.user_id = workers.worker_user_id", "WHERE worker_id = ". $delivery['order_worker_id'])[0] : ['user_username' => 'pendiente'] ;
        
        // autenticación
        $isAdmin = $_SESSION['user_role_id'] == 4 || $_SESSION['user_id'] == $delivery['order_user_id'] ? true : false;
        if (!$isAdmin) {header('location: /'); exit();}
        
        // obtener productos de la orden
        $inner_join_products = "INNER JOIN products ON sold_products.sold_product_product_id = products.product_id 
        INNER JOIN images ON products.product_id = images.image_object_id AND images.image_object_type = 'producto'";

        $products = $this -> soldProductModel -> getAll("*", $inner_join_products, "WHERE sold_product_order_id = $id");

        require_once(__DIR__ . "/../views/pay/shift.view.php");
    }

    public function order_receipt_pdf () {

        //lógica:

        $id = $_GET['id'];

        // obtener orden
        $inner_join_orders = "INNER JOIN users ON orders.order_user_id = users.user_id
        INNER JOIN states ON orders.order_state_id = states.state_id
        INNER JOIN receipts ON orders.order_id = receipts.receipt_order_id";

        $order = $this -> orderModel -> getById($id, "*", $inner_join_orders);

        // autenticación
        $isAdmin = $_SESSION['user_role_id'] == 4 || $_SESSION['user_id'] == $order['order_user_id'] ? true : false;
        if (!$isAdmin) {header('location: /'); exit();}
        
        // obtener productos de la orden
        $inner_join_products = "INNER JOIN products ON sold_products.sold_product_product_id = products.product_id 
        INNER JOIN images ON products.product_id = images.image_object_id AND images.image_object_type = 'producto'";

        $order['products'] = $this -> soldProductModel -> getAll("*", $inner_join_products, "WHERE sold_product_order_id = $id");

        require_once(__DIR__ . "/../services/FPDF/fpdf.php");
        require_once(__DIR__ . "/../views/pay/receipt.view.php");
    }
}