<?php

class Product extends Orm{
    public function __construct(mysqli $conn) {
        parent::__construct('producto_id', 'productos', $conn);
    }
    
}
