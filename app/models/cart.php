<?php

class Cart{

    public function getAll(){
        return $_SESSION['user_cart'];
    }

    public function add($product, $action = 'increase'){
        $found = false;
        foreach ($_SESSION['user_cart'] as &$item) {
            if ($item['product_id'] == $product['product_id']) {
                $item['product_quantity'] = $action == 'increase' ? $item['product_quantity'] + 1 : $item['product_quantity'] - 1 ;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $product['product_quantity'] = 1;
            $_SESSION['user_cart'][] = $product;
        }

        return ['success' => true, 'message' => 'La acción se realizó correctamente', 'cart' => $_SESSION['user_cart']];
    }

    public function remove($product){
        foreach ($_SESSION['user_cart'] as $key => $item) {
            if ($item['product_id'] == $product['product_id']) {
                array_splice($_SESSION['user_cart'], $key, 1);
                break;
            }
        }

        return ['success' => true, 'message' => 'Producto eliminado correctamente', 'cart' => $_SESSION['user_cart']];

    }

    public function empty(){
        $_SESSION['user_cart'] = [];
        
        return ['success' => true, 'message' => 'Carrito vaciado correctamente', 'cart' => $_SESSION['user_cart']];
        
    }

}