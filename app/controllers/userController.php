<?php
// /app/controllers/userController.php
require_once (__DIR__ . "/../models/user.php");

class UserController {
    private $userModel;

    public function __construct(mysqli $conn) {
        $this->userModel = new User($conn);
    }

    public function index() {
        $user = $this -> userModel -> getAll();
    }

    public function autenticate() {
        $post_data = file_get_contents('php://input');
        $post_data = json_decode($post_data, true);
        $result = $this -> userModel -> auth($post_data);

        header('Content-Type: application/json');  
        echo json_encode($result);
    }

    public function create() {
        $post_data = file_get_contents('php://input');
        $post_data = json_decode($post_data, true);
        
        $result = $this -> userModel -> insert($post_data);
    
        header('Content-Type: application/json');     
        echo json_encode($result);
    }
    
}

