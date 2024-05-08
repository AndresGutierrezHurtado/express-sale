<?php

class Seller extends Orm{
    public function __construct(mysqli $conn) {
        parent::__construct('seller_id', 'sellers', $conn);
    }
}