<?php

class saleController {

    private $saleModel;
    private $cartModel;

    public function __construct(mysqli $conn) {
        $this->saleModel = new Sale($conn);
        $this -> cartModel = new Cart();
    }

    public function create() {
        $data = $_POST;
        $result = $this->saleModel->insert($data);
        
        if ($result['success']) {
            $this -> cartModel -> empty();
        }
        echo json_encode($result);
    }

}

