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
        $cart = $this->cartModel->add($product);

        echo json_encode(['cart' => $cart]);
    }

}