<?php

class receipt extends Orm {
    public function  __construct(mysqli $conn) {
        parent::__construct('receipt_id', 'receipts', $conn);
    }
}