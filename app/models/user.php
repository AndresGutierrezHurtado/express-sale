<?php

class User extends Orm
{
    public function __construct(PDO $conn)
    {
        parent::__construct('usuario_id', 'usuarios', $conn);
    }

    public function auth($data)
    {

        $sql = "SELECT * FROM $this->table WHERE usuario_alias = :user OR usuario_correo = :user";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user', $data['usuario']);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (COUNT($user) > 0) {
            if (md5($data["usuario_contra"]) === $user["usuario_contra"]) {
                // Variables de sesión de usuarios
                $_SESSION["usuario_id"] = $user["usuario_id"];

                $_SESSION["carrito"] = array();
                $_SESSION["usuario_informacion"] = ['estado' => 'libre'];

                return ['success' => true, 'message' => 'La autenticación se realizó correctamente.'];
            } else {
                return ['success' => false, 'message' => 'La contraseña no coincide.'];
            }
        } else {
            return ['success' => false, 'message' => 'No se encuentra el usuario/correo.'];
        }
    }

    public function auth_google($data)
    {
        try {

            $data = [
                'usuario_correo' => $data['email'],
                'usuario_nombre' => $data['given_name'],
                'usuario_apellido' => $data['family_name'],
                'usuario_alias' => explode(" ", $data['given_name'])[0] . '_' . explode(" ", $data['family_name'])[0],
                'usuario_imagen_url' => $data['picture'],
            ];

            // verificar si existe un suaurio con ese correo
            $sql = "SELECT * FROM $this->table WHERE usuario_correo = :email";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':email', $data['usuario_correo']);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (COUNT($user) > 0) {
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
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al obtener los datos.', 'error' => $e->getMessage()];
        }
    }

    public function getSellerInfo($vendedorId, $trabajadorId, $año = null)
    {
        $result = [];

        $sql = "
        SELECT 
            YEAR(date_range.date) AS año,
            MONTH(date_range.date) AS mes,
            COALESCE(SUM(IF(productos.usuario_id = :vendedor_id, productos_pedidos.producto_cantidad, 0)), 0) AS numero_productos,
            COALESCE(SUM(IF(productos.usuario_id = :vendedor_id, productos_pedidos.producto_precio * productos_pedidos.producto_cantidad, 0)), 0) AS dinero_ventas
        FROM (
            SELECT DATE_ADD(CURRENT_DATE(), INTERVAL -i MONTH) AS date
            FROM (
                SELECT 0 AS i UNION ALL
                SELECT 1 UNION ALL
                SELECT 2 UNION ALL
                SELECT 3 UNION ALL
                SELECT 4 UNION ALL
                SELECT 5 UNION ALL
                SELECT 6 UNION ALL
                SELECT 7 UNION ALL
                SELECT 8 UNION ALL
                SELECT 9 UNION ALL
                SELECT 10 UNION ALL
                SELECT 11
            ) AS months
        ) AS date_range
        LEFT JOIN pedidos ON YEAR(pedidos.pedido_fecha) = YEAR(date_range.date) 
                           AND MONTH(pedidos.pedido_fecha) = MONTH(date_range.date)
        LEFT JOIN productos_pedidos ON productos_pedidos.pedido_id = pedidos.pedido_id
        LEFT JOIN productos ON productos_pedidos.producto_id = productos.producto_id 
                             AND productos.usuario_id = :vendedor_id
        GROUP BY YEAR(date_range.date), MONTH(date_range.date)
        ORDER BY YEAR(date_range.date), MONTH(date_range.date)
        ";

        if ($año) {
            $sql = "
            SELECT 
                :year AS año,
                meses.mes AS mes,
                COALESCE(SUM(IF(productos.usuario_id = :vendedor_id, productos_pedidos.producto_cantidad, 0)), 0) AS numero_productos,
                COALESCE(SUM(IF(productos.usuario_id = :vendedor_id, productos_pedidos.producto_precio * productos_pedidos.producto_cantidad, 0)), 0) AS dinero_ventas
            FROM (
                SELECT 1 AS mes UNION ALL
                SELECT 2 UNION ALL
                SELECT 3 UNION ALL
                SELECT 4 UNION ALL
                SELECT 5 UNION ALL
                SELECT 6 UNION ALL
                SELECT 7 UNION ALL
                SELECT 8 UNION ALL
                SELECT 9 UNION ALL
                SELECT 10 UNION ALL
                SELECT 11 UNION ALL
                SELECT 12
            ) AS meses                
            LEFT JOIN pedidos ON MONTH(pedidos.pedido_fecha) = meses.mes AND YEAR(pedidos.pedido_fecha) = :year 
            LEFT JOIN productos_pedidos ON productos_pedidos.pedido_id = pedidos.pedido_id
            LEFT JOIN productos ON productos_pedidos.producto_id = productos.producto_id AND productos.usuario_id = :vendedor_id
            GROUP BY meses.mes
            ORDER BY meses.mes
            ";
        }

        $stmt = $this->db->prepare($sql);
        if ($año !== null) {
            $stmt->bindValue(':year', $año, PDO::PARAM_INT);
        }
        $stmt->bindValue(':vendedor_id', $vendedorId, PDO::PARAM_INT);
        $stmt->execute();

        $result['ventas_mensuales'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Cantidad total de productos vendidos
        $sql = "
        SELECT SUM(productos_pedidos.producto_cantidad) AS cantidad_total_productos_vendidos
        FROM productos_pedidos 
        INNER JOIN productos ON productos_pedidos.producto_id = productos.producto_id 
        INNER JOIN usuarios ON productos.usuario_id = usuarios.usuario_id
        WHERE usuarios.usuario_id = :vendedor_id
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':vendedor_id', $vendedorId);
        $stmt->execute();
        $result['cantidad_total_productos_vendidos'] = $stmt->fetch(PDO::FETCH_ASSOC);

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
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $tmp_result = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
        WHERE productos.usuario_id = :vendedor_id
        GROUP BY productos.producto_id
        ORDER BY numero_ventas DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':vendedor_id', $vendedorId);
        $stmt->execute();
        $result['productos_mas_vendidos'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Verificar retiros
        $sql = "
        SELECT COUNT(*) AS retiros_mes
        FROM retiros
        WHERE trabajador_id = :trabajador_id
        AND MONTH(retiro_fecha) = MONTH(CURRENT_DATE())
        AND YEAR(retiro_fecha) = YEAR(CURRENT_DATE());
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':trabajador_id', $trabajadorId);
        $stmt->execute();

        $result['retiros_mes'] = $stmt->fetch(PDO::FETCH_ASSOC)['retiros_mes'];

        return $result;
    }

    public function getDeliveryInfo($vendedorId, $trabajadorId, $año = null)
    {
        $result = [];

        // obtener las ventas del vendedor
        if ($año === null) {
            $sql = "
            SELECT
                YEAR(date_range.date) AS año,
                MONTH(date_range.date) AS mes,
                COALESCE(SUM(IF(detalles_envios.trabajador_id = :trabajador_id AND pedidos.pedido_estado = 'recibido', 1, 0)), 0) as numero_envios,
                COALESCE(SUM(IF(detalles_envios.trabajador_id = :trabajador_id AND pedidos.pedido_estado = 'recibido', detalles_envios.envio_valor, 0)), 0) as dinero_envios
            FROM (
                SELECT DATE_ADD(CURRENT_DATE(), INTERVAL -i MONTH) AS date
                FROM (
                    SELECT 0 AS i UNION ALL
                    SELECT 1 UNION ALL
                    SELECT 2 UNION ALL
                    SELECT 3 UNION ALL
                    SELECT 4 UNION ALL
                    SELECT 5 UNION ALL
                    SELECT 6 UNION ALL
                    SELECT 7 UNION ALL
                    SELECT 8 UNION ALL
                    SELECT 9 UNION ALL
                    SELECT 10 UNION ALL
                    SELECT 11
                ) AS months
            ) AS date_range
            LEFT JOIN detalles_envios ON YEAR(detalles_envios.fecha_inicio) = YEAR(date_range.date) 
            AND MONTH(detalles_envios.fecha_inicio) = MONTH(date_range.date) 
            AND detalles_envios.trabajador_id = :trabajador_id
            LEFT JOIN pedidos ON detalles_envios.pedido_id = pedidos.pedido_id AND pedidos.pedido_estado = 'recibido'
            GROUP BY YEAR(date_range.date), MONTH(date_range.date)
            ORDER BY YEAR(date_range.date), MONTH(date_range.date);
        ";
        } else {
            $sql = "
            SELECT 
                :year AS año,
                meses.mes AS mes,
                COALESCE(SUM(IF(detalles_envios.trabajador_id = :trabajador_id AND pedidos.pedido_estado = 'recibido', 1, 0)), 0) as numero_envios,
                COALESCE(SUM(IF(detalles_envios.trabajador_id = :trabajador_id AND pedidos.pedido_estado = 'recibido', detalles_envios.envio_valor, 0)), 0) as dinero_envios
            FROM (
                SELECT 1 AS mes UNION ALL
                SELECT 2 UNION ALL
                SELECT 3 UNION ALL
                SELECT 4 UNION ALL
                SELECT 5 UNION ALL
                SELECT 6 UNION ALL
                SELECT 7 UNION ALL
                SELECT 8 UNION ALL
                SELECT 9 UNION ALL
                SELECT 10 UNION ALL
                SELECT 11 UNION ALL
                SELECT 12
            ) AS meses                
            LEFT JOIN detalles_envios ON MONTH(detalles_envios.fecha_inicio) = meses.mes 
                                AND YEAR(detalles_envios.fecha_inicio) = :year AND detalles_envios.trabajador_id = :trabajador_id
            LEFT JOIN pedidos ON detalles_envios.pedido_id = pedidos.pedido_id AND pedidos.pedido_estado = 'recibido'
            GROUP BY meses.mes
            ORDER BY meses.mes
            ";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':trabajador_id', $trabajadorId);
        $stmt->bindValue(':year', $año);
        $stmt->execute();
        $result['domicilios_mensuales'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Cantidad total de domicilios ehchos
        $sql = "
        SELECT COALESCE(COUNT(detalles_envios.pedido_id), 0) as cantidad_total_envios
        FROM detalles_envios 
        INNER JOIN pedidos ON detalles_envios.pedido_id = pedidos.pedido_id
        WHERE trabajador_id = :trabajador_id AND pedido_estado = 'recibido'
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':trabajador_id', $trabajadorId);
        $stmt->execute();

        $result['cantidad_total_envios'] = $stmt->fetch(PDO::FETCH_ASSOC)['cantidad_total_envios'];

        // Verificar retiros
        $sql = "
        SELECT COUNT(*) AS retiros_mes
        FROM retiros
        WHERE trabajador_id = :trabajador_id
        AND MONTH(retiro_fecha) = MONTH(CURRENT_DATE())
        AND YEAR(retiro_fecha) = YEAR(CURRENT_DATE());
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':trabajador_id', $trabajadorId);
        $stmt->execute();

        $result['retiros_mes'] = $stmt->fetch(PDO::FETCH_ASSOC)['retiros_mes'];

        return $result;
    }
}
