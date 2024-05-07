<?php

class Sale extends Orm{
    public function __construct(mysqli $conn) {
        parent::__construct('sale_id', 'sales', $conn);
    }
    
}
