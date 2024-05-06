<?php

class saleController {

    private $saleModel;

    public function __construct(mysqli $conn) {
        $this->saleModel = new Sale($conn);
    }

    public function create() {
        $data = $_POST;
        $result = $this->saleModel->insert($data);
        
        echo json_encode($result);
    }

}

