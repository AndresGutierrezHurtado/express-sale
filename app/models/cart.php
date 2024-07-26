<?php

class Cart{

    private $productModel;

    public function __construct($conn) {
        $this -> productModel = new Product($conn);
    }

    public function getAll(){
        $products = [];

        foreach($_SESSION['carrito'] as $product){
            $result = $this -> productModel -> getById($product['producto_id'], "productos.producto_nombre, productos.producto_id, productos.producto_imagen_url, productos.producto_precio");
            $result['producto_cantidad'] = $product['producto_cantidad'];
            array_push($products, $result);
        }

        return $products;
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

    public function getTotalPrice() {
        $totalPrice = 0;
        foreach ($_SESSION['carrito'] as $item) {
            $product = $this -> productModel -> getById($item['producto_id'], "producto_id, producto_precio");
            $totalPrice += floatval($product['producto_precio']) * intval($item['producto_cantidad']);
        }

        return $totalPrice;
    }

}