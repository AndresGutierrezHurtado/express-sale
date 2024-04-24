<?php
// /app/controllers/productController.php
require_once (__DIR__ . "/../models/product.php");

class ProductController {

    private $productModel;

    public function __construct(mysqli $conn) {
        $this->productModel = new Product($conn);
    }

    public function index() {
        $products = $this -> productModel -> getAll();
    }

    public function update() {
    if (!empty($_FILES['image']['name'])) {
        $product_id = $_POST['id'];

        // Obtener la extensión de la imagen
        $image_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        
        // Crear el nombre de archivo usando el product_id y el nombre del producto
        $image_name = $product_id . '.jpg';

        // Ruta de destino para guardar la imagen
        $image_path = '/public/images/products/' . $image_name;
        
        // Mover la imagen a la ubicación deseada en el servidor
        move_uploaded_file($_FILES['image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $image_path);
        
        // Actualizar la ruta de la imagen en los datos del producto
        $_POST['image'] = $image_path;
    }

    $result = $this->productModel->updateById($_POST['id'], $_POST);

    echo json_encode($result);
}

}

