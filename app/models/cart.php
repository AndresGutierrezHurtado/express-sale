<?php


class Cart{
    public function add($product){
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $product['id']) {
                $item['quantity'] += 1;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $product['quantity'] = 1;
            $_SESSION['cart'][] = $product;
        }

        return $_SESSION['cart'];
    }

    public function getAll(){
        return $_SESSION['cart'];
    }

}