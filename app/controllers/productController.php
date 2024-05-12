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
        
        echo json_encode($result);
    }

    public function update() {
        if (!empty($_FILES['image']['name'])) {
            
            $image_path = '/public/images/products/' . $_POST['product_id'] . '.jpg';
            
            // guardar imagen en los directorios
            move_uploaded_file($_FILES['image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $image_path);
            $_POST['image_url'] = $image_path;
        }

        $result = $this->productModel->updateById($_POST['product_id'], $_POST, "INNER JOIN images ON products.product_id = images.image_object_id AND images.image_object_type = 'producto'");
        echo json_encode($result);
    }

    public function delete() {
        $post_data = file_get_contents('php://input');
        $post_data = json_decode( $post_data , true);

        $result = $this -> productModel -> deleteById($post_data['id']);

        echo json_encode($result);
    }

}

