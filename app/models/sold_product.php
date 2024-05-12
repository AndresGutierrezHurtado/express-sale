<?php

class soldProduct extends Orm{
    public function __construct(mysqli $conn) {
        parent::__construct('sold_product_id', 'sold_products', $conn);
    }
    
}