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

    public function login() {
        $result = $this -> userModel -> auth($_POST);

        echo json_encode($result);
    }

    public function create() {
        $result = $this -> userModel -> insert($_POST);
    
        echo json_encode($result);
    }

    public function update() {
        // Verificar si se ha enviado una imagen
        if (!empty($_FILES['image']['name'])) {
            $user_id = $_POST['user_id'];
    
            $image_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            
            $image_name = $user_id . '.jpg';
            $image_path = '/public/images/users/' . $image_name;
            
            // Mover la imagen a la ubicación deseada en el servidor
            move_uploaded_file($_FILES['image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $image_path);
            
            // Actualizar la ruta de la imagen en los datos del usuario
            $_POST['image'] = $image_path;
        }
        $result = $this -> userModel -> updateById($_POST['user_id'], $_POST);
        
        echo json_encode($result);
    }

    public function delete() {
        $post_data = file_get_contents('php://input');
        $post_data = json_decode( $post_data , true);

        $result = $this -> userModel -> deleteById($post_data['id']);

        echo json_encode($result);
    }

    public function log_out() {
        session_destroy();
        echo json_encode(['success' => true, 'message' => 'Sesión cerrada.']);
    }
    
}

