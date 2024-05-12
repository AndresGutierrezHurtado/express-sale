<?php

class Order extends Orm{
    public function __construct(mysqli $conn) {
        parent::__construct('order_id', 'orders', $conn);
    }
    
}
