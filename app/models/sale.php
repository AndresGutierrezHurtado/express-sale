<?php

class Sale extends Orm{
    public function __construct(mysqli $conn) {
        parent::__construct('id', 'sales', $conn);
    }
    
}
