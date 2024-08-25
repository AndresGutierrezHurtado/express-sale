<?php

class Order extends Orm
{
    public function __construct(mysqli $conn)
    {
        parent::__construct('pedido_id', 'pedidos', $conn);
    }

    public function getOrders($customQuery = "")
    {
        $temp_orders = $this->getAll(
            "pedidos.*, detalles_pagos.*, detalles_envios.*, categorias.*,
            productos_pedidos.*, productos.producto_nombre, productos.producto_imagen_url, 
            domiciliarios.usuario_id as domiciliario_id, domiciliarios.usuario_alias as domiciliario_alias,
            vendedores.usuario_direccion as vendedor_direccion, vendedores.usuario_alias as vendedor_alias, vendedores.usuario_id as vendedor_id",
            " INNER JOIN detalles_pagos ON pedidos.pedido_id = detalles_pagos.pago_id
            INNER JOIN detalles_envios ON pedidos.pedido_id = detalles_envios.pedido_id 
            INNER JOIN productos_pedidos ON pedidos.pedido_id = productos_pedidos.pedido_id 
            LEFT JOIN trabajadores ON detalles_envios.trabajador_id = trabajadores.trabajador_id
            LEFT JOIN usuarios as domiciliarios ON trabajadores.usuario_id = domiciliarios.usuario_id
            INNER JOIN productos ON productos_pedidos.producto_id = productos.producto_id 
            INNER JOIN categorias ON productos.categoria_id = categorias.categoria_id
            INNER JOIN usuarios as vendedores ON productos.usuario_id = vendedores.usuario_id",
            $customQuery
        );

        $orders = [];

        foreach ($temp_orders as $temp_order) {
            $order_id = $temp_order['pedido_id'];

            if (!array_key_exists($order_id, $orders)) {
                $orders[$order_id] = array(
                    'pedido_id' => $temp_order['pedido_id'],
                    'pedido_fecha' => $temp_order['pedido_fecha'],
                    'pedido_estado' => $temp_order['pedido_estado'],
                    'pago_id' => $temp_order['pago_id'],
                    'pago_valor' => $temp_order['pago_valor'],
                    'comprador_nombre' => $temp_order['comprador_nombre'],
                    'comprador_correo' => $temp_order['comprador_correo'],
                    'comprador_telefono' => $temp_order['comprador_telefono'],
                    'domiciliario_id' => $temp_order['domiciliario_id'],
                    'domiciliario_alias' => $temp_order['domiciliario_alias'],
                    'envio_direccion' => $temp_order['envio_direccion'],
                    'envio_coordenadas' => $temp_order['envio_coordenadas'],
                    'envio_mensaje' => $temp_order['envio_mensaje'],
                    'usuario_id' => $temp_order['usuario_id'],
                    'products' => array()
                );
            }

            $orders[$order_id]['productos'][] = array(
                'producto_id' => $temp_order['producto_id'],
                'producto_cantidad' => $temp_order['producto_cantidad'],
                'producto_precio' => $temp_order['producto_precio'],
                'producto_nombre' => $temp_order['producto_nombre'],
                'producto_imagen_url' => $temp_order['producto_imagen_url'],
                'producto_categoria' => $temp_order['categoria_nombre'],
                'usuario_direccion' => $temp_order['vendedor_direccion'],
                'usuario_alias' => $temp_order['vendedor_alias'],
                'usuario_id' => $temp_order['vendedor_id']
            );
        }

        return $orders;
    }

    public function getOrder($id)
    {

        $select_orders = "pedidos.*, detalles_pagos.*, detalles_envios.*, trabajadores.trabajador_id, trabajadores.trabajador_numero_trabajos,
        domiciliarios.usuario_id as domiciliario_id, domiciliarios.usuario_alias as domiciliario_alias, 
        productos_pedidos.*, productos.producto_nombre, productos.producto_imagen_url, 
        vendedores.usuario_id as vendedor_id, vendedores.usuario_alias, vendedores.usuario_direccion";

        $inner_join_orders = " INNER JOIN detalles_pagos ON pedidos.pedido_id = detalles_pagos.pago_id
        INNER JOIN detalles_envios ON pedidos.pedido_id = detalles_envios.pedido_id 
        INNER JOIN productos_pedidos ON pedidos.pedido_id = productos_pedidos.pedido_id 
        INNER JOIN productos ON productos_pedidos.producto_id = productos.producto_id
        INNER JOIN usuarios as vendedores ON productos.usuario_id = vendedores.usuario_id
        LEFT JOIN trabajadores ON detalles_envios.trabajador_id = trabajadores.trabajador_id
        LEFT JOIN usuarios as domiciliarios ON trabajadores.usuario_id = domiciliarios.usuario_id";

        $orders_consulta = $this->getAll($select_orders, $inner_join_orders, "WHERE pedidos.pedido_id = " . $id);

        $orders = [];

        foreach ($orders_consulta as $order_consulta) {
            $order_id = $order_consulta['pedido_id'];

            if (!array_key_exists($order_id, $orders)) {
                $orders[$order_id] = array(
                    'pedido_id' => $order_consulta['pedido_id'],
                    'pedido_fecha' => $order_consulta['pedido_fecha'],
                    'pedido_estado' => $order_consulta['pedido_estado'],
                    'pago_id' => $order_consulta['pago_id'],
                    'pago_valor' => $order_consulta['pago_valor'],
                    'comprador_nombre' => $order_consulta['comprador_nombre'],
                    'comprador_correo' => $order_consulta['comprador_correo'],
                    'comprador_telefono' => $order_consulta['comprador_telefono'],
                    'envio_direccion' => $order_consulta['envio_direccion'],
                    'envio_coordenadas' => $order_consulta['envio_coordenadas'],
                    'envio_mensaje' => $order_consulta['envio_mensaje'],
                    'fecha_entrega' => $order_consulta['fecha_entrega'],
                    'domiciliario_id' => $order_consulta['domiciliario_id'],
                    'domiciliario_alias' => $order_consulta['domiciliario_alias'],
                    'trabajador_numero_trabajos' => $order_consulta['trabajador_numero_trabajos'],
                    'usuario_id' => $order_consulta['usuario_id'],
                    'products' => array()
                );
            }

            $orders[$order_id]['productos'][] = array(
                'producto_id' => $order_consulta['producto_id'],
                'producto_cantidad' => $order_consulta['producto_cantidad'],
                'producto_precio' => $order_consulta['producto_precio'],
                'producto_nombre' => $order_consulta['producto_nombre'],
                'producto_imagen_url' => $order_consulta['producto_imagen_url'],
                'usuario_direccion' => $order_consulta['usuario_direccion'],
                'usuario_id' => $order_consulta['vendedor_id'],
                'usuario_alias' => $order_consulta['usuario_alias']
            );
        }

        return $orders[$id];
    }

    public function getTotalDistance($id)
    {
        $totalDistance = 0;
        $order = $this->getOrder($id);

        foreach ($order['productos'] as $i => $producto) {
            $origen = $order['productos'][$i]['usuario_direccion'];
            $destino = ($i == count($order['productos']) - 1) ? $destino = $order['envio_direccion'] : $destino = $order['productos'][$i]['usuario_direccion'];

            $totalDistance += $this->getDistance($origen, $destino)['distance']['value'];
        }

        return $totalDistance;
    }

    public function getDistance($origen, $destino)
    {
        $data = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?destinations=" . urlencode($origen) . "&origins=" . urlencode($destino) . "&units=meters&key=" . API_MAPS), true);

        $data['status'] == 'OK' ? $data = $data['rows'][0]['elements'][0] : $data = 0;
        return $data;
    }
}

class PaymentDetails extends Orm
{
    public function __construct(mysqli $conn)
    {
        parent::__construct('pago_id', 'detalles_pagos', $conn);
    }
}

class SoldProduct extends Orm
{
    public function __construct(mysqli $conn)
    {
        parent::__construct('', 'productos_pedidos', $conn);
    }
}

class ShippingDetails extends Orm
{
    public function __construct(mysqli $conn)
    {
        parent::__construct('envio_id', 'detalles_envios', $conn);
    }
}
