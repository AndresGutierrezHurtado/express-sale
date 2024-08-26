<?php

class User extends Orm
{
    public function __construct(mysqli $conn)
    {
        parent::__construct('usuario_id', 'usuarios', $conn);
    }

    public function auth($data)
    {
        $username = $data['usuario_alias'];
        $query = "SELECT * FROM $this->table WHERE usuario_alias = '$username' OR usuario_correo = '$username'";
        $result = $this->db->query($query);

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (md5($data["usuario_contraseña"]) === $user["usuario_contraseña"]) {
                // Variables de sesión de usuarios
                $_SESSION["usuario_id"] = $user["usuario_id"];

                $_SESSION["carrito"] = array();
                $_SESSION["usuario_informacion"] = ['estado' => 'libre'];

                return ['success' => true, 'message' => 'La inserción se realizó correctamente.'];
            } else {
                return ['success' => false, 'message' => 'La contraseña no coincide.'];
            }
        } else {
            return ['success' => false, 'message' => 'No se encuentra el usuario/correo.'];
        }
    }

    public function auth_google($data)
    {
        $data = [
            'usuario_correo' => $data['email'],
            'usuario_nombre' => $data['given_name'],
            'usuario_apellido' => $data['family_name'],
            'usuario_alias' => explode(" ", $data['given_name'])[0] . '_' . explode(" ", $data['family_name'])[0],
            'usuario_imagen_url' => $data['picture'],
        ];

        // verificar si existe un suaurio con ese correo
        $query = "SELECT * FROM $this->table WHERE usuario_correo = '" . $data['usuario_correo'] . "'";
        $result = $this->db->query($query);

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION["usuario_id"] = $user["usuario_id"];

            $_SESSION["carrito"] = array();
            $_SESSION["usuario_informacion"] = ['estado' => 'libre'];

            return ['success' => true, 'message' => 'La inserción se realizó correctamente.'];
        } else {
            $result = $this->insert($data);

            if ($result['success']) {
                $user = $this->getById($result['last_id']);

                $_SESSION["usuario_id"] = $user["usuario_id"];

                $_SESSION["carrito"] = array();
                $_SESSION["usuario_informacion"] = ['estado' => 'libre'];

                return ['success' => true, 'message' => 'La inserción se realizó correctamente.'];
            }
        }
    }

    public function getSellerInfo($vendedorId, $trabajadorId, $mes = null, $año = null)
    {
        $result = [];

        $mes = $mes ?? date('m');
        $año = $año ?? date('Y');

        // Información del mes (dinero hecho en ventas y número de ventas)

        $sql = "
        SELECT SUM(productos_pedidos.producto_cantidad) AS numero_ventas, SUM(productos_pedidos.producto_precio * productos_pedidos.producto_cantidad) AS dinero_ventas
        FROM pedidos
        INNER JOIN productos_pedidos ON productos_pedidos.pedido_id = pedidos.pedido_id
        INNER JOIN productos ON productos_pedidos.producto_id = productos.producto_id
        WHERE productos.usuario_id = $vendedorId AND MONTH(pedidos.pedido_fecha) = $mes AND YEAR(pedidos.pedido_fecha) = $año
        ";
        $result['informacion_mes'] = $this->db->query($sql)->fetch_assoc();

        // Cantidad total de productos vendidos

        $sql = "
        SELECT SUM(productos_pedidos.producto_cantidad) AS cantidad_total_productos_vendidos
        FROM productos_pedidos 
        INNER JOIN productos ON productos_pedidos.producto_id = productos.producto_id 
        INNER JOIN usuarios ON productos.usuario_id = usuarios.usuario_id
        WHERE usuarios.usuario_id = $vendedorId
        ";
        $result['cantidad_total_productos_vendidos'] = $this->db->query($sql)->fetch_assoc();

        // Todos los pedidos con productos del vendedor

        $sql = "
        SELECT pedidos.*, categorias.*, productos.producto_id,
        usuarios.usuario_nombre, usuarios.usuario_apellido,
        productos.producto_nombre, productos.producto_imagen_url, 
        productos_pedidos.producto_precio, productos_pedidos.producto_cantidad
        FROM productos_pedidos 
        INNER JOIN productos ON productos_pedidos.producto_id = productos.producto_id
        INNER JOIN categorias ON productos.categoria_id = categorias.categoria_id
        INNER JOIN pedidos ON productos_pedidos.pedido_id = pedidos.pedido_id
        INNER JOIN usuarios ON pedidos.usuario_id = usuarios.usuario_id
        WHERE productos.usuario_id = 2;
        ";
        $tmp_result = $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);

        $result['todos_los_pedidos'] = [];

        foreach ($tmp_result as $order) {
            $order_id = $order['pedido_id'];

            if (!array_key_exists($order_id, $result['todos_los_pedidos'])) {
                $result['todos_los_pedidos'][$order_id] = array(
                    'pedido_id' => $order['pedido_id'],
                    'pedido_fecha' => $order['pedido_fecha'],
                    'pedido_estado' => $order['pedido_estado'],
                    'comprador_nombre' => $order['usuario_nombre'] . " " . $order['usuario_apellido'],
                    'products' => array()
                );
            }


            $result['todos_los_pedidos'][$order_id]['productos'][] = array(
                'producto_id' => $order['producto_id'],
                'producto_nombre' => $order['producto_nombre'],
                'producto_imagen_url' => $order['producto_imagen_url'],
                'producto_cantidad' => $order['producto_cantidad'],
                'producto_precio' => $order['producto_precio'],
                'producto_categoria' => $order['categoria_nombre'],
            );
        }

        // Productos más vendidos

        $sql = "
        SELECT productos.producto_id, productos.producto_nombre, productos.producto_imagen_url, COALESCE(SUM(productos_pedidos.producto_cantidad), 0) AS numero_ventas 
        FROM productos
        LEFT JOIN productos_pedidos ON productos_pedidos.producto_id = productos.producto_id
        WHERE productos.usuario_id = $vendedorId
        GROUP BY productos.producto_id
        ORDER BY numero_ventas DESC
        ";
        $result['productos_mas_vendidos'] = $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);

        // Verificar retiros
        $sql = "
        SELECT COUNT(*) AS retiros_mes
        FROM retiros
        WHERE trabajador_id = $trabajadorId
        AND MONTH(retiro_fecha) = MONTH(CURRENT_DATE())
        AND YEAR(retiro_fecha) = YEAR(CURRENT_DATE());
        ";
        $result['retiros_mes'] = $this->db->query($sql)->fetch_assoc()['retiros_mes'];

        return $result;
    }
    
}
