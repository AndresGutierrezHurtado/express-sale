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
        if (!empty($_FILES['product_image']['name'])) {
            $product_id = $_POST['product_id'];

            $image_extension = pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION);
            
            $image_name = $product_id . '.jpg';
            $image_path = '/public/images/products/' . $image_name;
            
            move_uploaded_file($_FILES['product_image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $image_path);
            $_POST['product_image'] = $image_path;
        }

        $result = $this->productModel->updateById($_POST['product_id'], $_POST);
        echo json_encode($result);
    }

    public function delete() {
        $post_data = file_get_contents('php://input');
        $post_data = json_decode( $post_data , true);

        $result = $this -> productModel -> deleteById($post_data['id']);

        echo json_encode($result);
    }

}

