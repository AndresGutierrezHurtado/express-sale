<?php

class ProductController {

    private $productModel;

    public function __construct(mysqli $conn) {
        $this->productModel = new Product($conn);
    }

    public function index() {
        $products = $this -> productModel -> getAll();
    }

    public function create(){
        $result = $this -> productModel -> insert($_POST);
        
        if (!empty($_FILES['producto_imagen']['name']) && $result['success']) {
            
            $_POST['producto_imagen_url'] = '/public/images/products/' . $result['last_id'] . '.jpg';
            
            move_uploaded_file($_FILES['producto_imagen']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $_POST['producto_imagen_url']);

            $result = $this -> productModel -> updateById($result['last_id'], $_POST);
        }

        echo json_encode($result);
    }

    public function update() {
        if (!empty($_FILES['producto_imagen']['name'])) {            
            $_POST['producto_imagen_url'] = '/public/images/products/' . $_POST['producto_id'] . '.jpg';
            
            // guardar imagen en los directorios
            move_uploaded_file($_FILES['producto_imagen']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $_POST['producto_imagen_url']);
        }

        $result = $this->productModel->updateById($_POST['producto_id'], $_POST);
        echo json_encode($result);
    }

    public function delete() {
        $post_data = file_get_contents('php://input');
        $post_data = json_decode( $post_data , true);

        $result = $this -> productModel -> deleteById($post_data['id']);

        echo json_encode($result);
    }

}

