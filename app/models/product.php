<?php

class Product extends Orm{
    public function __construct(mysqli $conn) {
        parent::__construct('product_id', 'products', $conn);
    }
    
}
