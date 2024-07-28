<?php
class PageController {
    
    private $productModel;
    private $userModel;
    private $cartModel;
    private $orderModel;
    private $soldProductModel;
    private $calificationModel;
    private $multimediaModel;

    public function __construct(mysqli $conn) { 
        $this -> productModel = new Product($conn);
        $this -> userModel = new User($conn);
        $this -> cartModel = new Cart($conn);
        $this -> orderModel = new Order($conn);
        $this -> soldProductModel = new soldProduct($conn);
        $this -> calificationModel = new Calification($conn);
        $this -> multimediaModel = new Multimedia($conn);
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

    public function product() {
        
        $product = $this -> productModel -> getProduct($_GET['product']);

        $title = $product['producto_nombre'];
        $content = __DIR__ . "/../views/pages/product.view.php";

        require_once(__DIR__ . "/../views/layouts/app.layout.php");
    }

    public function sellers () {

        // vendedor
        $seller = $this -> userModel -> getById($_GET['seller'], 
        " usuarios.*, trabajadores.*, 
        COUNT(calificaciones_usuarios.calificacion_id) AS numero_calificaciones, 
        ROUND(IFNULL(AVG(calificaciones.calificacion), 0), 2) AS calificacion_promedio, 
        COUNT(CASE WHEN calificaciones.calificacion = 1 THEN 1 END) AS calificaciones_1, 
        COUNT(CASE WHEN calificaciones.calificacion = 2 THEN 1 END) AS calificaciones_2, 
        COUNT(CASE WHEN calificaciones.calificacion = 3 THEN 1 END) AS calificaciones_3, 
        COUNT(CASE WHEN calificaciones.calificacion = 4 THEN 1 END) AS calificaciones_4, 
        COUNT(CASE WHEN calificaciones.calificacion = 5 THEN 1 END) AS calificaciones_5 ", 
        " INNER JOIN trabajadores ON usuarios.usuario_id = trabajadores.usuario_id
        LEFT JOIN calificaciones_usuarios ON usuarios.usuario_id = calificaciones_usuarios.usuario_id
        LEFT JOIN calificaciones ON calificaciones_usuarios.calificacion_id = calificaciones.calificacion_id ", 
        "GROUP BY usuarios.usuario_id");

        // calificaciones vendedor
        $califications = $this -> calificationModel -> getAll("*", 
        " INNER JOIN calificaciones_usuarios ON calificaciones.calificacion_id = calificaciones_usuarios.calificacion_id
        INNER JOIN usuarios ON calificaciones.usuario_id = usuarios.usuario_id ", 
        "WHERE calificaciones_usuarios.usuario_id = " . $seller['usuario_id']);

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

    public function delivery() {
        // Obtener domiciliario
        $user = $this -> userModel -> getById($_GET['delivery'], "usuarios.*, trabajadores.*, roles.*,
        COUNT(calificaciones_usuarios.calificacion_id) AS numero_calificaciones, 
        ROUND(IFNULL(AVG(calificaciones.calificacion), 0), 2) AS calificacion_promedio, 
        COUNT(CASE WHEN calificaciones.calificacion = 1 THEN 1 END) AS calificaciones_1, 
        COUNT(CASE WHEN calificaciones.calificacion = 2 THEN 1 END) AS calificaciones_2, 
        COUNT(CASE WHEN calificaciones.calificacion = 3 THEN 1 END) AS calificaciones_3, 
        COUNT(CASE WHEN calificaciones.calificacion = 4 THEN 1 END) AS calificaciones_4, 
        COUNT(CASE WHEN calificaciones.calificacion = 5 THEN 1 END) AS calificaciones_5 ", 
        " INNER JOIN roles ON usuarios.rol_id = roles.rol_id
        INNER JOIN trabajadores ON usuarios.usuario_id = trabajadores.usuario_id
        LEFT JOIN calificaciones_usuarios ON usuarios.usuario_id = calificaciones_usuarios.usuario_id
        LEFT JOIN calificaciones ON calificaciones_usuarios.calificacion_id = calificaciones.calificacion_id ",
        " GROUP BY usuarios.usuario_id " );

        if ($user['rol_id'] != 3) {header('location: /'); exit();}

        // Calificaciones
        $califications = $this -> calificationModel -> getAll("*", 
        " INNER JOIN calificaciones_usuarios ON calificaciones.calificacion_id = calificaciones_usuarios.calificacion_id
        INNER JOIN usuarios ON calificaciones.usuario_id = usuarios.usuario_id ", 
        "WHERE calificaciones_usuarios.usuario_id = " . $user['usuario_id']);
        
        $title = "Domiciliario";
        $content = __DIR__ . "/../views/pages/delivery.view.php";

        require_once(__DIR__ . "/../views/layouts/guest.layout.php");
    }

    public function profile() {
        // MiddleWare
        $id = isset($_GET['id']) ? $_GET['id'] : $_SESSION['usuario_id'] ;
        $isAdmin = $_SESSION['rol_id'] == 4 || $_SESSION['usuario_id'] == $id ? true : false;
        if (!$isAdmin) {header('location: /'); exit();}

        // User
        $select_user = "usuarios.*, roles.*, trabajadores.trabajador_descripcion";
        $inner_join_user = " INNER JOIN roles ON usuarios.rol_id = roles.rol_id
        LEFT JOIN trabajadores ON usuarios.usuario_id = trabajadores.usuario_id ";
        $user = $this -> userModel -> getById($id, $select_user, $inner_join_user);

        // Orders
        $orders = $this -> orderModel -> getOrders("WHERE pedidos.usuario_id = $id");

        // Products
        $products_page = isset($_GET['products_page']) ? $_GET['products_page'] : 1 ;
        if ($user['rol_nombre'] == 'vendedor') {
            $products = $this -> productModel -> paginate($products_page, 5, '*', "INNER JOIN categorias ON productos.categoria_id = categorias.categoria_id", "WHERE productos.usuario_id = $id", "WHERE productos.usuario_id = $id");
        }
        
        $title = "Perfil";
        $content = __DIR__ . "/../views/pages/profile/user.view.php";

        require_once(__DIR__ . "/../views/layouts/app.layout.php");
        
    }

    public function stats() {
        // MiddleWare
        $id = isset($_GET['id']) ? $_GET['id'] : $_SESSION['usuario_id'] ;
        if (!$_SESSION['rol_id'] == 4 || $_SESSION['usuario_id'] == $id ? true : false) {header('location: /'); exit();}

        // User
        $user = $this -> userModel -> getById($id);

        $title = "Estadísticas";

        if ($user['rol_id'] == 2) {
            $content = __DIR__ . "/../views/pages/profile/stats_seller.view.php";
        } else if ($user['rol_id'] == 3) {
            $content = __DIR__ . "/../views/pages/profile/stats_delivery.view.php";
        }

        require_once(__DIR__ . "/../views/layouts/guest.layout.php");
    }

    public function product_profile() {
        // obtener datos del producto
        $select_products = "productos.*,
        COUNT(multimedias.producto_id) AS numero_multimedias";

        $product = $this -> productModel -> getById( $_GET['producto'] , $select_products, " LEFT JOIN multimedias ON productos.producto_id = multimedias.producto_id ");

        // obtener multimedias
        $multimedias = $this -> multimediaModel -> getAll("*", "", "WHERE producto_id = " . $product['producto_id'] );

        // // MiddleWare
        $isAdmin = $_SESSION['rol_id'] == 4 || $_SESSION['usuario_id'] == $product['usuario_id'] ? true : false;
        if (!$isAdmin) {header('location: /'); exit();}

        $title = "Perfil de Producto";
        $content = __DIR__ . "/../views/pages/profile/product.view.php";

        require_once(__DIR__ . "/../views/layouts/app.layout.php");
    }

    public function order () {

        // Orders
        $id = $_GET['order'];
        $order = $this -> orderModel -> getOrder($id);

        // MiddleWare
        $isAdmin = $_SESSION['rol_id'] == 4 || $_SESSION['usuario_id'] == $order['usuario_id'] ? true : false;
        if (!$isAdmin) {header('location: /'); exit();}

        $title = "Pedido";
        $content = __DIR__ . "/../views/pages/pay/order.view.php";

        require_once(__DIR__ . "/../views/layouts/guest.layout.php");
    }
    
    public function receipt () {

        // Order
        $id = $_GET['receipt'];

        $select_orders = "pedidos.*, detalles_pagos.*, detalles_envios.*, productos_pedidos.*, productos.producto_nombre, productos.producto_imagen_url";

        $inner_join_orders = " INNER JOIN detalles_pagos ON pedidos.pedido_id = detalles_pagos.pago_id
        INNER JOIN detalles_envios ON pedidos.pedido_id = detalles_envios.pedido_id 
        INNER JOIN productos_pedidos ON pedidos.pedido_id = productos_pedidos.pedido_id 
        INNER JOIN productos ON productos_pedidos.producto_id = productos.producto_id";

        $orders_consulta = $this -> orderModel -> getAll($select_orders, $inner_join_orders, "WHERE pedidos.pedido_id = " . $id);

        $order = [];

        foreach ($orders_consulta as $order_consulta) {
            $order_id = $order_consulta['pedido_id'];

            if (!array_key_exists($order_id, $order)) {
                $order[$order_id] = array(
                    'pedido_id' => $order_consulta['pedido_id'],
                    'pago_id' => $order_consulta['pago_id'],
                    'pedido_fecha' => $order_consulta['pedido_fecha'],
                    'comprador_nombre' => $order_consulta['comprador_nombre'],
                    'comprador_correo' => $order_consulta['comprador_correo'],
                    'comprador_telefono' => $order_consulta['comprador_telefono'],
                    'envio_direccion' => $order_consulta['envio_direccion'],
                    'envio_coordenadas' => $order_consulta['envio_coordenadas'],
                    'usuario_id' => $order_consulta['usuario_id'],
                    'pago_valor' => $order_consulta['pago_valor'],
                    'pedido_estado' => $order_consulta['pedido_estado'],
                    'products' => array()
                );
            }
        
            $order[$order_id]['productos'][] = array(
                'producto_id' => $order_consulta['producto_id'],
                'producto_cantidad' => $order_consulta['producto_cantidad'],
                'producto_precio'=> $order_consulta['producto_precio'],
                'producto_nombre' => $order_consulta['producto_nombre'],
                'producto_imagen_url' => $order_consulta['producto_imagen_url']
            );
        }

        $order = $order[$id];

        // autenticación
        $isAdmin = $_SESSION['rol_id'] == 4 || $_SESSION['usuario_id'] == $order['usuario_id'] ? true : false;
        if (!$isAdmin) {header('location: /'); exit();}
        
        require_once(__DIR__ . "/../services/FPDF/fpdf.php");
        require_once(__DIR__ . "/../views/pages/pay/receipt.view.php");
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

    public function shipments () {
        // autenticación
        if ( $_SESSION['usuario_informacion']['estado'] == 'ocupado' ) header('location: /page/shipment/?shipment='. $_SESSION['usuario_informacion']['pedido_id'] );
        if ( ! $_SESSION['rol_id'] == 4 || ! $_SESSION['rol_id'] == 3) header('location: /');

        // obtener las ordenes pendientes
        $orders = $this -> orderModel -> getOrders("WHERE pedido_estado = 'pendiente'");

        $title = "Pedido";
        $content = __DIR__ . "/../views/pages/delivery/shipments.view.php";

        require_once(__DIR__ . "/../views/layouts/guest.layout.php");
    }

    public function shipment () {
        // obtener detalles de la orden
        $id = $_GET['shipment'];
        $order = $this -> orderModel -> getOrder($id);
        $trabajador = $this -> userModel -> getById($_SESSION['usuario_id'], "*", "INNER JOIN trabajadores ON usuarios.usuario_id = trabajadores.usuario_id");

        if ($order['pedido_estado'] == 'pendiente') {
            // actualizar al domiciliario y su orden
            $distancia_total = $this -> orderModel -> getTotalDistance($id);
            $envio_valor = $distancia_total > 10000 ? $distancia_total * 1.3 : 10000;
            $_SESSION['usuario_informacion'] = ['estado' => 'ocupado', 'pedido_id'=> $id];
            
            $this -> orderModel -> updateById($id, ['trabajador_id' => $trabajador['trabajador_id'], 'pedido_estado' => 'enviando',  'envio_valor' => $envio_valor], "INNER JOIN detalles_envios ON pedidos.pedido_id = detalles_envios.pedido_id");
        
        }

        $title = "Pedido";
        $content = __DIR__ . "/../views/pages/delivery/shipment.view.php";

        require_once(__DIR__ . "/../views/layouts/guest.layout.php");
    }
}