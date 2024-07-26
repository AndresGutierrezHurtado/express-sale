<?php

class Cart{

    public function getAll(){
        return $_SESSION['carrito'];
    }

    public function add($product, $action = 'increase'){
        $found = false;
        foreach ($_SESSION['carrito'] as &$item) {
            if ($item['producto_id'] == $product['producto_id']) {
                $item['producto_cantidad'] = $action == 'increase' ? $item['producto_cantidad'] + 1 : $item['producto_cantidad'] - 1 ;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $product['producto_cantidad'] = 1;
            $_SESSION['carrito'][] = $product;
        }

        return ['success' => true, 'message' => 'La acción se realizó correctamente', 'cart' => $_SESSION['carrito']];
    }

    public function remove($product){
        foreach ($_SESSION['carrito'] as $key => $item) {
            if ($item['producto_id'] == $product['producto_id']) {
                array_splice($_SESSION['carrito'], $key, 1);
                break;
            }
        }

        return ['success' => true, 'message' => 'Producto eliminado correctamente', 'cart' => $_SESSION['carrito']];
    }

    public function empty(){
        $_SESSION['carrito'] = [];
        
        return ['success' => true, 'message' => 'Carrito vaciado correctamente', 'cart' => $_SESSION['carrito']];        
    }

}