<?php 

class SellerController {
    private $sellerModel;
    public function __construct(mysqli $conn) {
        $this->sellerModel = new Seller ($conn);
    }

    public function update () {
        $data = $_POST;
        
        $result = $this->sellerModel->updateById($data['seller_id'], $data);

        echo json_encode($result);
    }
}