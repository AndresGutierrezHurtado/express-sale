<?php

class Product extends Orm{
    public function __construct(mysqli $conn) {
        parent::__construct('id', 'products', $conn);
    }    
}
