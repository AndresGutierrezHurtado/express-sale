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
        $this -> cartModel = new Cart($conn);
        $this -> orderModel = new Order($conn);
        $this -> soldProductModel = new soldProduct($conn);
        $this -> calificationModel = new Calification($conn);
    }
    
    public function home(){
        $title = "Inicio";
        $content = __DIR__ . "/../views/pages/home.view.php";

        require_once(__DIR__ . "/../views/layouts/app.layout.php");
    }  

    public function login(){
        $title = "Inicia Sesión";
        $content = __DIR__ . "/../views/pages/auth/login.view.php";

        require_once(__DIR__ . "/../views/layouts/guest.layout.php");
    }
    public function register(){
        $title = "Regístrate";
        $content = __DIR__ . "/../views/pages/auth/register.view.php";

        require_once(__DIR__ . "/../views/layouts/guest.layout.php");
    }

    public function recover_account () {
        require_once(__DIR__ . "/../views/auth/recover_account.view.php");
    }
    
    public function payprocess () {
        $title = "Formulario de pago";
        $content = __DIR__ . "/../views/pages/pay/form.view.php";

        $totalPrice = $this -> cartModel -> getTotalPrice();
        $products = $this -> cartModel -> getAll();

        $reference_code = md5(date('Ymd') . '-' . $_SESSION['usuario_id'] . microtime(true));
        
        // "ApiKey~merchantId~referenceCode~amount~currency~paymentMethods~iin~pseBanks"
        $signature = md5(PAYU_API_KEY . '~' . PAYU_MERCHANT_ID . '~' . $reference_code . '~' . $totalPrice . '~' . 'COP' );

        require_once(__DIR__ . "/../views/layouts/guest.layout.php");
    }

    public function cart() {
        $products = $this -> cartModel -> getAll();

        $title = "Carrito";
        $content = __DIR__ . "/../views/pages/pay/cart.view.php";

        require_once(__DIR__ . "/../views/layouts/app.layout.php");
    }
    
    public function products(){
        // filtros y sorts
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $categoria = isset($_GET['categoria']) ? " categorias.categoria_id = " . $_GET['categoria'] . " AND" : "";

        // Búsqueda
        $search = isset($_GET['search']) ? "(producto_nombre LIKE '%".$_GET['search']."%' OR producto_descripcion LIKE '%".$_GET['search']."%' OR usuarios.usuario_alias LIKE '%".$_GET['search']."%') AND" : "" ;

        $min = isset($_GET['min']) ? $_GET['min'] : 0;
        $max = isset($_GET['max']) ? $_GET['max'] : 1000000000;
        $minmax = "producto_precio > $min AND producto_precio < $max";

        // Select
        $select = "productos.*, usuarios.usuario_alias,
        COUNT(calificaciones_productos.producto_id) AS numero_calificaciones,
        ROUND(IFNULL(AVG(calificaciones.calificacion), 0), 2) AS calificacion_promedio ";

        // Inner join
        $inner_join = "
        INNER JOIN categorias ON productos.categoria_id = categorias.categoria_id
        INNER JOIN usuarios ON productos.usuario_id = usuarios.usuario_id
        LEFT JOIN calificaciones_productos ON productos.producto_id = calificaciones_productos.producto_id
        LEFT JOIN calificaciones ON calificaciones_productos.calificacion_id = calificaciones.calificacion_id
        ";

        // Order By
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'calificacion_promedio';
        $sortQuery = $sort == 'producto_precio' ? "ORDER BY $sort ASC " :  "ORDER BY $sort DESC" ;

        // Armar consulta con todo lo anterior
        $queryRows = "WHERE $search $categoria $minmax";
        $query = "WHERE $search $categoria $minmax GROUP BY productos.producto_id $sortQuery";

        function buildQueryString( $add = [], $remove = []) {
            $params = $_GET;
            $queryString = '?';
            foreach ($params as $key => $param) {
                if (!in_array($key, $remove) && !array_key_exists($key, $add)) {
                    $queryString.= $key . '=' . $param . '&';
                }
            }
            foreach ($add as $key => $param) {
                $queryString.= $key . '=' . $param . '&';
            }
            $queryString = rtrim($queryString, '&');
            return $queryString;
        }
        
        $products = $this -> productModel -> paginate($page, 5, $select, $inner_join, $queryRows, $query);

        $title = "Productos";
        $content = __DIR__ . "/../views/pages/products.view.php";

        require_once(__DIR__ . "/../views/layouts/app.layout.php");
    }

    public function sellers () {

        // vendedor
        $select_seller = " usuarios.*, trabajadores.*, 
        COUNT(calificaciones_usuarios.calificacion_id) AS numero_calificaciones, 
        ROUND(IFNULL(AVG(calificaciones.calificacion), 0), 2) AS calificacion_promedio, 
        COUNT(CASE WHEN calificaciones.calificacion = 1 THEN 1 END) AS calificaciones_1, 
        COUNT(CASE WHEN calificaciones.calificacion = 2 THEN 1 END) AS calificaciones_2, 
        COUNT(CASE WHEN calificaciones.calificacion = 3 THEN 1 END) AS calificaciones_3, 
        COUNT(CASE WHEN calificaciones.calificacion = 4 THEN 1 END) AS calificaciones_4, 
        COUNT(CASE WHEN calificaciones.calificacion = 5 THEN 1 END) AS calificaciones_5 ";

        $inner_join_seller = " INNER JOIN trabajadores ON usuarios.usuario_id = trabajadores.usuario_id
        LEFT JOIN calificaciones_usuarios ON usuarios.usuario_id = calificaciones_usuarios.usuario_id
        LEFT JOIN calificaciones ON calificaciones_usuarios.calificacion_id = calificaciones.calificacion_id ";

        $seller = $this -> userModel -> getById($_GET['seller'], $select_seller, $inner_join_seller, " GROUP BY usuarios.usuario_id");

        // calificaciones vendedor
        $inner_join_califications = " INNER JOIN calificaciones_usuarios ON calificaciones.calificacion_id = calificaciones_usuarios.calificacion_id
        INNER JOIN usuarios ON calificaciones_usuarios.usuario_id = usuarios.usuario_id";

        $califications = $this -> calificationModel -> getAll("*", $inner_join_califications, "WHERE calificaciones_usuarios.usuario_id = " . $seller['usuario_id']);

        // productos vendedor
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        
        $select_products = "productos.*, usuarios.usuario_alias,
        COUNT(calificaciones_productos.producto_id) AS numero_calificaciones,
        ROUND(IFNULL(AVG(calificaciones.calificacion), 0), 2) AS calificacion_promedio ";

        $inner_join_products = " INNER JOIN categorias ON productos.categoria_id = categorias.categoria_id
        INNER JOIN usuarios ON productos.usuario_id = usuarios.usuario_id
        LEFT JOIN calificaciones_productos ON productos.producto_id = calificaciones_productos.producto_id
        LEFT JOIN calificaciones ON calificaciones_productos.calificacion_id = calificaciones.calificacion_id ";

        $query_products = "WHERE productos.usuario_id = " . $seller['usuario_id'] . " GROUP BY productos.producto_id ORDER BY AVG(calificaciones.calificacion) DESC";
        
        $products = $this -> productModel -> paginate($page, 5, $select_products, $inner_join_products, $query_products, $query_products);


        $title = $seller['usuario_alias'];
        $content = __DIR__ . "/../views/pages/seller.view.php";

        require_once(__DIR__ . "/../views/layouts/app.layout.php");
    }

    public function profile() {
        // MiddleWare
        $id = isset($_GET['id']) ? $_GET['id'] : $_SESSION['usuario_id'] ;
        $isAdmin = $_SESSION['rol_id'] == 4 || $_SESSION['usuario_id'] == $id ? true : false;
        if (!$isAdmin) {header('location: /'); exit();}

        // User
        $inner_join = " INNER JOIN roles ON usuarios.rol_id = roles.rol_id
        LEFT JOIN trabajadores ON usuarios.usuario_id = trabajadores.usuario_id ";
        $user = $this -> userModel -> getById($id, "*", $inner_join);

        // Orders
        // $orders_inner_join = "INNER JOIN states ON orders.order_state_id = states.state_id
        // INNER JOIN sold_products ON sold_products.sold_product_order_id = orders.order_id
        // INNER JOIN products ON sold_products.sold_product_product_id = products.product_id ";

        // $deliveries = $this -> orderModel -> getAll("*", $orders_inner_join, "WHERE orders.order_usuario_id = $id");

        // $orders = [];

        // foreach ($deliveries as $order) {
        //     $order_id = $order['order_id'];

        //     if (!array_key_exists($order_id, $orders)) {
        //         $orders[$order_id] = array(
        //             'order_id' => $order['order_id'],
        //             'order_date' => $order['order_date'],
        //             'order_first_name' => $order['order_first_name'],
        //             'order_last_name' => $order['order_last_name'],
        //             'order_address' => $order['order_address'],
        //             'order_coords' => $order['order_coords'],
        //             'order_usuario_id' => $order['order_usuario_id'],
        //             'order_amount' => $order['order_amount'],
        //             'state_name' => $order['state_name'],
        //             'products' => array()
        //         );
        //     }
        
        //     $orders[$order_id]['products'][] = array(
        //         'sold_product_id' => $order['sold_product_id'],
        //         'sold_product_quantity' => $order['sold_product_quantity'],
        //         'sold_product_address' => $order['sold_product_address'],
        //         'product_name'=> $order['product_name']
        //     );
        // }

        // $deliveries['rows'] = count($orders);

        // Products
        $products_page = isset($_GET['products_page']) ? $_GET['products_page'] : 1 ;
        if ($user['rol_nombre'] == 'vendedor') {
            $products = $this -> productModel -> paginate($products_page, 5, '*', "INNER JOIN categorias ON productos.categoria_id = categorias.categoria_id", "WHERE productos.usuario_id = $id", "WHERE productos.usuario_id = $id");
        }
        
        $title = "Perfil";
        $content = __DIR__ . "/../views/pages/profile/user.view.php";

        require_once(__DIR__ . "/../views/layouts/app.layout.php");
        
    }

    public function product_profile() {
        // obtener datos del producto
        $product = $this -> productModel -> getById( $_GET['id'] , "*", "INNER JOIN usuarios ON products.product_usuario_id = usuarios.usuario_id 
        INNER JOIN images ON products.product_id = images.image_object_id AND images.image_object_type = 'producto'");
        
        // Autenticación
        $isAdmin = $_SESSION['rol_id'] == 4 || $_SESSION['usuario_id'] == $product['product_usuario_id'] ? true : false;
        if (!$isAdmin) {header('location: /'); exit();}

        require_once(__DIR__. "/../views/profile/product.view.php");
    }

    public function dashboard_usuarios() {
        // Autenticación
        $isAdmin = $_SESSION['rol_id'] == 4 ? true : false;
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
        usuario_id LIKE '%".$_GET['search']."%')" : "" ;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'usuario_id';

        $queryRows = "$search";
        $query = "$search ORDER BY $sort ASC";
        $usuarios = $this -> userModel -> paginate($page, 5, "*", "INNER JOIN roles ON usuarios.rol_id = roles.role_id", $queryRows, $query);

        $user_session = $this -> userModel -> getById($_SESSION['usuario_id'], "*", "INNER JOIN images ON usuarios.usuario_id = images.image_object_id AND images.image_object_type = 'usuario'");
        require_once(__DIR__ . "/../views/admin/dashboard_usuarios.view.php");
    }
    
    public function dashboard_products() {
        // Autenticación
        $isAdmin = $_SESSION['rol_id'] == 4 ? true : false;
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
        INNER JOIN usuarios ON products.product_usuario_id = usuarios.usuario_id";

        $products = $this -> productModel -> paginate($page, 5, "*", $inner_join, $queryRows, $query);
        
        $user_session = $this -> userModel -> getById($_SESSION['usuario_id'], "*", "INNER JOIN images ON usuarios.usuario_id = images.image_object_id AND images.image_object_type = 'usuario'");
        require_once(__DIR__ . "/../views/admin/dashboard_products.view.php");
    }

    public function delivery_list () {
        // autenticación
        if ($_SESSION['user_delivery']['state'] == 'busy') { header('location: /page/delivery/?id='. $_SESSION['user_delivery']['order_id'] ); exit(); }
        $isAdmin = $_SESSION['rol_id'] == 4 || $_SESSION['rol_id'] == 3 ? true : false;
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
                    'order_usuario_id' => $order['order_usuario_id'],
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
        $worker = $this -> userModel -> getById($_SESSION['usuario_id'], "*", "INNER JOIN workers ON usuarios.usuario_id = workers.worker_usuario_id");
        $this -> orderModel -> updateById($id, ['order_worker_id' => $worker['worker_id']]);
        
        // obtener detalles de la orden
        $inner_join_orders = "INNER JOIN usuarios ON orders.order_usuario_id = usuarios.usuario_id
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
        $inner_join_orders = "INNER JOIN usuarios ON orders.order_usuario_id = usuarios.usuario_id
        INNER JOIN states ON orders.order_state_id = states.state_id";

        $delivery = $this -> orderModel -> getById($id, "*", $inner_join_orders);

        // obtener domiciliario
        $worker = isset($delivery['order_worker_id']) ? $this -> userModel -> getAll("*", "INNER JOIN workers ON usuarios.usuario_id = workers.worker_usuario_id", "WHERE worker_id = ". $delivery['order_worker_id'])[0] : ['user_username' => 'pendiente'] ;
        
        // autenticación
        $isAdmin = $_SESSION['rol_id'] == 4 || $_SESSION['usuario_id'] == $delivery['order_usuario_id'] ? true : false;
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
        $inner_join_orders = "INNER JOIN usuarios ON orders.order_usuario_id = usuarios.usuario_id
        INNER JOIN states ON orders.order_state_id = states.state_id
        INNER JOIN receipts ON orders.order_id = receipts.receipt_order_id";

        $order = $this -> orderModel -> getById($id, "*", $inner_join_orders);

        // autenticación
        $isAdmin = $_SESSION['rol_id'] == 4 || $_SESSION['usuario_id'] == $order['order_usuario_id'] ? true : false;
        if (!$isAdmin) {header('location: /'); exit();}
        
        // obtener productos de la orden
        $inner_join_products = "INNER JOIN products ON sold_products.sold_product_product_id = products.product_id 
        INNER JOIN images ON products.product_id = images.image_object_id AND images.image_object_type = 'producto'";

        $order['products'] = $this -> soldProductModel -> getAll("*", $inner_join_products, "WHERE sold_product_order_id = $id");

        require_once(__DIR__ . "/../services/FPDF/fpdf.php");
        require_once(__DIR__ . "/../views/pay/receipt.view.php");
    }
}