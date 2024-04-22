<?php
// /app/controllers/userController.php
require_once (__DIR__ . "/../models/user.php");

class UserController {
    private $userModel;

    public function __construct(mysqli $conn) {
        $this->userModel = new User($conn);
    }

    public function index() {
        $products = $this -> userModel -> getAll();
    }

    public function create() {
        $post_data = file_get_contents('php://input');
        $post_data = json_decode($post_data, true);
        $result = $this -> userModel -> insert($post_data);

        if ($result['success']) {
            echo json_encode(['success' => true, 'message' => 'El usuario se creó correctamente.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al crear el usuario: ' . $result['message']]);
        }
    }

}

