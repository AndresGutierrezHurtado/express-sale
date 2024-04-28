<?php
require_once (__DIR__ . "/../models/cart.php");

session_start();

class cartController {
    
    private $cartModel;
    public function __construct() {
        $this->cartModel = new Cart();
    }

    public function add() {
        $product = $_POST;
        $result = $this->cartModel->add($product);

        echo json_encode($result);
    }

    public function update() {
        $product = $_POST;
        $result = $this -> cartModel -> add($product, $product['action'] );

        echo json_encode($result);
    }

    public function delete() {
        $product = $_POST;
        $result = $this -> cartModel -> remove($product);

        echo json_encode($result);
    }

    public function empty () {
        $result = $this -> cartModel -> empty();

        echo json_encode($result);
    }

}