<?php
class PageController extends Controller
{

    public function __construct(PDO $conn)
    {
        parent::__construct($conn);
    }

    public function home()
    {
        $title = "Inicio";
        $content = __DIR__ . "/../views/pages/home.view.php";

        require_once(__DIR__ . "/../views/layouts/app.layout.php");
    }

    public function login()
    {
        if (isset($_SESSION['usuario_id'])) header('location: /');

        $auth_url = 'https://accounts.google.com/o/oauth2/auth?' . http_build_query([
            'client_id' => CLIENT_ID,
            'redirect_uri' => REDIRECT_URL,
            'response_type' => 'code',
            'scope' => 'email profile'
        ]);

        $title = "Inicia Sesión";
        $content = __DIR__ . "/../views/pages/auth/login.view.php";

        require_once(__DIR__ . "/../views/layouts/guest.layout.php");
    }
    public function register()
    {
        if (isset($_SESSION['usuario_id'])) header('location: /');

        $auth_url = 'https://accounts.google.com/o/oauth2/auth?' . http_build_query([
            'client_id' => CLIENT_ID,
            'redirect_uri' => REDIRECT_URL,
            'response_type' => 'code',
            'scope' => 'email profile'
        ]);

        $title = "Regístrate";
        $content = __DIR__ . "/../views/pages/auth/register.view.php";

        require_once(__DIR__ . "/../views/layouts/guest.layout.php");
    }

    public function recover_account()
    {

        $title = "Recupera tu cuenta";
        $content = __DIR__ . "/../views/pages/auth/recover_account.view.php";

        require_once(__DIR__ . "/../views/layouts/guest.layout.php");
    }

    public function reset_password()
    {
        $sql = "SELECT * FROM recuperacion_cuentas WHERE token = :token  LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':token', $_GET['token']);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            if (new DateTime() < new DateTime($result['fecha_expiracion'])) {
                $title = "Cambia tu contraseña";
                $content = __DIR__ . "/../views/pages/auth/reset_password.view.php";

                require_once(__DIR__ . "/../views/layouts/guest.layout.php");
            } else {
                echo "El token ha expirado. Solicite un nuevo enlace de recuperación.";
            }
        }
    }

    public function payprocess()
    {
        $title = "Formulario de pago";
        $content = __DIR__ . "/../views/pages/pay/form.view.php";

        $totalPrice = $this->cartModel->getTotalPrice();
        $products = $this->cartModel->getAll();

        $reference_code = md5(date('Ymd') . '-' . $_SESSION['usuario_id'] . microtime(true));

        $signature = md5(PAYU_API_KEY . '~' . PAYU_MERCHANT_ID . '~' . $reference_code . '~' . $totalPrice . '~' . 'COP');

        require_once(__DIR__ . "/../views/layouts/guest.layout.php");
    }

    public function cart()
    {
        // MiddleWare
        if (!isset($_SESSION['usuario_id'])) header("location: /");

        $products = $this->cartModel->getAll();

        $title = "Carrito";
        $content = __DIR__ . "/../views/pages/pay/cart.view.php";

        require_once(__DIR__ . "/../views/layouts/app.layout.php");
    }

    public function products()
    {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;

        // Búsqueda
        $search = isset($_GET['search']) ? "(producto_nombre LIKE '%" . $_GET['search'] . "%' OR producto_descripcion LIKE '%" . $_GET['search'] . "%' OR usuarios.usuario_alias LIKE '%" . $_GET['search'] . "%') AND" : "";

        // filtros y sorts
        $categoria = isset($_GET['categoria']) ? " categorias.categoria_id = " . $_GET['categoria'] . " AND" : "";

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
        $sortQuery = $sort == 'producto_precio' ? "$sort ASC " :  "$sort DESC";

        $products = $this->productModel->paginate($page, 5, $select, $inner_join, "$search $categoria $minmax", $sortQuery, "productos.producto_id");

        $title = "Productos";
        $content = __DIR__ . "/../views/pages/products.view.php";

        require_once(__DIR__ . "/../views/layouts/app.layout.php");
    }

    public function product()
    {

        // Product
        $product = $this->productModel->getProduct($_GET['product']);

        // MiddleWare
        if ($product['producto_estado'] == 'privado') header("location: /");

        $title = $product['producto_nombre'];
        $content = __DIR__ . "/../views/pages/product.view.php";

        require_once(__DIR__ . "/../views/layouts/app.layout.php");
    }

    public function sellers()
    {

        // vendedor
        $seller = $this->userModel->getById(
            $_GET['seller'],
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
            "GROUP BY usuarios.usuario_id"
        );

        // calificaciones vendedor
        $califications = $this->calificationModel->getAll(
            "*",
            " INNER JOIN calificaciones_usuarios ON calificaciones.calificacion_id = calificaciones_usuarios.calificacion_id
            INNER JOIN usuarios ON calificaciones.usuario_id = usuarios.usuario_id ",
            "calificaciones_usuarios.usuario_id = " . $seller['usuario_id']
        );

        // productos vendedor
        $page = isset($_GET['page']) ? $_GET['page'] : 1;

        $products = $this->productModel->paginate(
            $page,
            5,
            "productos.*, usuarios.usuario_alias,
            COUNT(calificaciones_productos.producto_id) AS numero_calificaciones,
            ROUND(IFNULL(AVG(calificaciones.calificacion), 0), 2) AS calificacion_promedio ",
            " INNER JOIN categorias ON productos.categoria_id = categorias.categoria_id
            INNER JOIN usuarios ON productos.usuario_id = usuarios.usuario_id
            LEFT JOIN calificaciones_productos ON productos.producto_id = calificaciones_productos.producto_id
            LEFT JOIN calificaciones ON calificaciones_productos.calificacion_id = calificaciones.calificacion_id ",
            "productos.usuario_id = " . $seller['usuario_id'],
            "AVG(calificaciones.calificacion) DESC",
            "productos.producto_id"
        );


        $title = $seller['usuario_alias'];
        $content = __DIR__ . "/../views/pages/seller.view.php";

        require_once(__DIR__ . "/../views/layouts/app.layout.php");
    }

    public function delivery()
    {
        // Obtener domiciliario
        $user = $this->userModel->getById(
            $_GET['delivery'],
            "usuarios.*, trabajadores.*, roles.*,
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
            " GROUP BY usuarios.usuario_id "
        );

        if ($user['rol_id'] != 3) {
            header('location: /');
            exit();
        }

        // Calificaciones
        $califications = $this->calificationModel->getAll(
            "*",
            " INNER JOIN calificaciones_usuarios ON calificaciones.calificacion_id = calificaciones_usuarios.calificacion_id
            INNER JOIN usuarios ON calificaciones.usuario_id = usuarios.usuario_id ",
            "calificaciones_usuarios.usuario_id = " . $user['usuario_id']
        );

        $title = "Domiciliario";
        $content = __DIR__ . "/../views/pages/delivery.view.php";

        require_once(__DIR__ . "/../views/layouts/guest.layout.php");
    }

    public function profile()
    {

        // MiddleWare
        $id = isset($_GET['id']) ? $_GET['id'] : $_SESSION['usuario_id'];
        if (!isset($_SESSION['usuario_id']) || $id != $_SESSION['usuario_id'] && $_SESSION['usuario']['rol_id'] != 4) header("location: /");

        // User
        $user = $this->userModel->getById(
            $id,
            "usuarios.*, roles.*, trabajadores.trabajador_descripcion",
            "INNER JOIN roles ON usuarios.rol_id = roles.rol_id
            LEFT JOIN trabajadores ON usuarios.usuario_id = trabajadores.usuario_id"
        );

        // Orders
        $orders = $this->orderModel->getOrders("pedidos.usuario_id = $id");

        $title = "Perfil";
        $content = __DIR__ . "/../views/pages/profile/user.view.php";

        require_once(__DIR__ . "/../views/layouts/app.layout.php");
    }

    public function stats()
    {
        // MiddleWare
        $id = isset($_GET['id']) ? $_GET['id'] : $_SESSION['usuario_id'];
        if (!isset($_SESSION['usuario_id']) || $id != $_SESSION['usuario_id'] && $_SESSION['usuario']['rol_id'] != 4) header("location: /");

        // User
        $user = $this->userModel->getById($id, "*", "INNER JOIN roles ON usuarios.rol_id = roles.rol_id INNER JOIN trabajadores ON usuarios.usuario_id = trabajadores.usuario_id");

        $title = "Estadísticas " . $user['rol_nombre'];
        $current_page = "stats";

        if ($user['rol_id'] == 2) {
            $result = $this->userModel->getSellerInfo($id, $user['trabajador_id'], isset($_GET['año']) ? $_GET['año'] : null);
            $result['cantidad_pedidos_pendientes'] = count($this->orderModel->getOrders("vendedores.usuario_id = $id AND pedidos.pedido_estado = 'Pendiente'"));
            $result['cantidad_total_productos'] = count(
                $this->productModel->getAll(
                    "*",
                    "INNER JOIN categorias ON productos.categoria_id = categorias.categoria_id",
                    "productos.usuario_id = $id"
                )
            );

            $content = __DIR__ . "/../views/pages/profile/stats_seller.view.php";
        } else if ($user['rol_id'] == 3) {
            $result = $this->userModel->getDeliveryInfo($id, $user['trabajador_id'], isset($_GET['año']) ? $_GET['año'] : null);
            $content = __DIR__ . "/../views/pages/profile/stats_delivery.view.php";
        }

        require_once(__DIR__ . "/../views/layouts/stats.layout.php");
    }

    public function shipments()
    {
        // MiddleWare
        $id = isset($_GET['seller']) ? $_GET['seller'] : $_SESSION['usuario_id'];
        if ($_SESSION['usuario_informacion']['estado'] == 'ocupado') header('location: /page/shipment/?shipment=' . $_SESSION['usuario_informacion']['pedido_id']);
        if (! $_SESSION['usuario']['rol_id'] == 4 || ! $_SESSION['usuario']['rol_id'] == 3) header('location: /');

        // Obtener las ordenes pendientes
        $orders = $this->orderModel->getOrders("pedido_estado = 'pendiente'");
        $user = $this->userModel->getById($id, "*", "INNER JOIN roles ON usuarios.rol_id = roles.rol_id INNER JOIN trabajadores ON usuarios.usuario_id = trabajadores.usuario_id");

        $title = "Domicilios";
        $current_page = "products";
        $content = __DIR__ . "/../views/pages/delivery/shipments.view.php";

        require_once(__DIR__ . "/../views/layouts/stats.layout.php");
    }

    public function seller_products()
    {
        // MiddleWare
        $id = isset($_GET['seller']) ? $_GET['seller'] : $_SESSION['usuario_id'];
        if (!$_SESSION['usuario']['rol_id'] == 4 || !$_SESSION['usuario_id'] == $id) {
            header('location: /');
            exit();
        }

        // User
        $user = $this->userModel->getById($id, "*", "INNER JOIN roles ON usuarios.rol_id = roles.rol_id INNER JOIN trabajadores ON usuarios.usuario_id = trabajadores.usuario_id");

        // Products
        $products_page = isset($_GET['products_page']) ? $_GET['products_page'] : 1;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'producto_id';
        $order = isset($_GET['order']) ? $_GET['order'] : 'ASC';

        $search = isset($_GET['search']) ? "AND ( productos.producto_nombre LIKE '%" . $_GET['search'] . "%' OR categorias.categoria_nombre LIKE '%" . $_GET['search'] . "%' ) " : "";
        if ($user['rol_nombre'] == 'vendedor') {
            $products = $this->productModel->paginate(
                $products_page,
                5,
                '*',
                "INNER JOIN categorias ON productos.categoria_id = categorias.categoria_id",
                "productos.usuario_id = $id $search",
                "$sort $order"
            );
        }

        $title = "Productos " . $user['rol_nombre'];
        $current_page = "products";
        $content = __DIR__ . "/../views/pages/profile/seller_products.view.php";

        require_once(__DIR__ . "/../views/layouts/stats.layout.php");
    }

    public function product_profile()
    {
        $product = $this->productModel->getProduct($_GET['producto']);

        // MiddleWare
        if (!$_SESSION['usuario']['rol_id'] == 4 || !$_SESSION['usuario_id'] == $product['usuario_id']) {
            header('location: /');
            exit();
        }

        $title = "Perfil de Producto";
        $content = __DIR__ . "/../views/pages/profile/product.view.php";

        require_once(__DIR__ . "/../views/layouts/app.layout.php");
    }

    public function order()
    {

        // Orders
        $id = $_GET['order'];
        $order = $this->orderModel->getOrder($id);

        // MiddleWare
        $isAdmin = $_SESSION['usuario']['rol_id'] == 4 || $_SESSION['usuario_id'] == $order['usuario_id'] ||  $_SESSION['usuario']['rol_id'] == 2;
        if (!$isAdmin) {
            header('location: /');
            exit();
        }

        $title = "Pedido";
        $content = __DIR__ . "/../views/pages/pay/order.view.php";

        require_once(__DIR__ . "/../views/layouts/guest.layout.php");
    }

    public function receipt()
    {

        // Order
        $id = $_GET['receipt'];

        $select_orders = "pedidos.*, detalles_pagos.*, detalles_envios.*, productos_pedidos.*, productos.producto_nombre, productos.producto_imagen_url";

        $inner_join_orders = " INNER JOIN detalles_pagos ON pedidos.pedido_id = detalles_pagos.pago_id
        INNER JOIN detalles_envios ON pedidos.pedido_id = detalles_envios.pedido_id 
        INNER JOIN productos_pedidos ON pedidos.pedido_id = productos_pedidos.pedido_id 
        INNER JOIN productos ON productos_pedidos.producto_id = productos.producto_id";

        $orders_consulta = $this->orderModel->getAll($select_orders, $inner_join_orders, "pedidos.pedido_id = $id ");

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
                'producto_precio' => $order_consulta['producto_precio'],
                'producto_nombre' => $order_consulta['producto_nombre'],
                'producto_imagen_url' => $order_consulta['producto_imagen_url']
            );
        }

        $order = $order[$id];

        // autenticación
        $isAdmin = $_SESSION['usuario']['rol_id'] == 4 || $_SESSION['usuario_id'] == $order['usuario_id'] ? true : false;
        if (!$isAdmin) {
            header('location: /');
            exit();
        }

        require_once(__DIR__ . "/../services/FPDF/fpdf.php");
        require_once(__DIR__ . "/../views/pages/pay/receipt.view.php");
    }

    public function dashboard_users()
    {
        // Autenticación
        $isAdmin = $_SESSION['usuario']['rol_id'] == 4 ? true : false;
        if (!$isAdmin) {
            header('location: /');
            exit();
        }

        // Filtros y sorts para obtener los usuarios
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $search = isset($_GET['search']) ? "( usuarios.usuario_nombre LIKE '%" . $_GET['search'] . "%' OR usuarios.usuario_correo LIKE '%" . $_GET['search'] . "%' OR usuarios.usuario_alias LIKE '%" . $_GET['search'] . "%' ) "  : "";

        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'usuario_id';

        $users = $this->userModel->paginate(
            $page,
            5,
            "*",
            "INNER JOIN roles ON usuarios.rol_id = roles.rol_id",
            "$search",
            "$sort ASC"
        );

        $user_session = $this->userModel->getById($_SESSION['usuario_id'], "*");

        $title = "Dashboard de usuarios";
        $content = __DIR__ . "/../views/pages/admin/dashboard_users.view.php";

        require_once(__DIR__ . "/../views/layouts/guest.layout.php");
    }

    public function dashboard_products()
    {
        // Autenticación
        $isAdmin = $_SESSION['usuario']['rol_id'] == 4 ? true : false;
        if (!$isAdmin) {
            header('location: /');
            exit();
        }

        // Filtros y sorts para obtener los productos
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $search = isset($_GET['search']) ? "( 
        productos.producto_nombre LIKE '%" . $_GET['search'] . "%' OR 
        productos.producto_descripcion LIKE '%" . $_GET['search'] . "%' OR 
        categorias.categoria_nombre LIKE '%" . $_GET['search'] . "%' OR 
        usuarios.usuario_alias LIKE '% " . $_GET['search'] . "%' )" : "";

        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'producto_id';

        $products = $this->productModel->paginate(
            $page,
            5,
            "*",
            "INNER JOIN categorias ON productos.categoria_id = categorias.categoria_id 
            INNER JOIN usuarios ON productos.usuario_id = usuarios.usuario_id",
            $search,
            "$sort ASC"
        );

        $user_session = $this->userModel->getById($_SESSION['usuario_id'], "*");

        $title = "Dashboard de productos";
        $content = __DIR__ . "/../views/pages/admin/dashboard_products.view.php";

        require_once(__DIR__ . "/../views/layouts/guest.layout.php");
    }

    public function shipment()
    {
        // obtener detalles de la orden
        $id = $_GET['shipment'];
        $order = $this->orderModel->getOrder($id);
        $trabajador = $this->userModel->getById($_SESSION['usuario_id'], "*", "INNER JOIN trabajadores ON usuarios.usuario_id = trabajadores.usuario_id");

        if ($order['pedido_estado'] == 'pendiente') {
            // actualizar al domiciliario y su orden
            $distancia_total = $this->orderModel->getTotalDistance($id);
            $envio_valor = $distancia_total > 10000 ? $distancia_total * 1.3 : 10000;
            $_SESSION['usuario_informacion'] = ['estado' => 'ocupado', 'pedido_id' => $id];

            $this->orderModel->updateById($id, ['trabajador_id' => $trabajador['trabajador_id'], 'pedido_estado' => 'enviando',  'envio_valor' => $envio_valor], "INNER JOIN detalles_envios ON pedidos.pedido_id = detalles_envios.pedido_id");
        }

        $title = "Pedido";
        $content = __DIR__ . "/../views/pages/delivery/shipment.view.php";

        require_once(__DIR__ . "/../views/layouts/guest.layout.php");
    }

    public function buildQueryString($add = [], $remove = [])
    {
        $params = $_GET;
        $queryString = '?';
        foreach ($params as $key => $param) {
            if (!in_array($key, $remove) && !array_key_exists($key, $add)) {
                $queryString .= $key . '=' . $param . '&';
            }
        }
        foreach ($add as $key => $param) {
            $queryString .= $key . '=' . $param . '&';
        }
        $queryString = rtrim($queryString, '&');
        return $queryString;
    }
}
