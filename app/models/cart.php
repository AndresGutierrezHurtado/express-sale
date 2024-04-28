<?php


class Cart{

    public function getAll(){
        return $_SESSION['cart'];
    }

    public function add($product, $action = 'increase'){
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $product['id']) {
                $item['quantity'] = $action == 'increase' ? $item['quantity'] + 1 : $item['quantity'] - 1 ;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $product['quantity'] = 1;
            $_SESSION['cart'][] = $product;
        }

        return ['success' => true, 'message' => 'La acción se realizó correctamente', 'cart' => $_SESSION['cart']];
    }

    public function remove($product){
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['id'] == $product['id']) {
                array_splice($_SESSION['cart'], $key, 1);
                break;
            }
        }

        return ['success' => true, 'message' => 'Producto eliminado correctamente', 'cart' => $_SESSION['cart']];

    }

    public function empty(){
        $_SESSION['cart'] = [];
        
        return ['success' => true, 'message' => 'Carrito vaciado correctamente', 'cart' => $_SESSION['cart']];
        
    }

}