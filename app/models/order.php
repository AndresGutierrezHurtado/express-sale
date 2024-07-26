<?php

class Order extends Orm{
    public function __construct(mysqli $conn) {
        parent::__construct('pedido_id', 'pedidos', $conn);
    }
}

class PaymentDetails extends Orm {
    public function __construct(mysqli $conn) {
        parent::__construct('pago_id', 'detalles_pagos', $conn);
    }
}

class SoldProduct extends Orm {
    public function __construct(mysqli $conn) {
        parent::__construct('', 'productos_pedidos', $conn);
    }
}

class ShippingDetails extends Orm {
    public function __construct(mysqli $conn) {
        parent::__construct('envio_id', 'detalles_envios', $conn);
    }
}
