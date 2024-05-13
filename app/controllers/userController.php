<?php

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

            $image_path = '/public/images/users/' . $_POST['user_id'] . '.jpg';     

            // Mover la imagen a la ubicación deseada en en directorio
            move_uploaded_file($_FILES['image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $image_path);
            
            $_POST['image_url'] = $image_path;
        }
        
        $result = $this -> userModel -> updateById($_POST['user_id'], $_POST, "INNER JOIN images ON users.user_id = images.image_object_id AND images.image_object_type = 'usuario'
        INNER JOIN workers ON users.user_id = workers.worker_user_id");
        
        
        $_SESSION['user_delivery'] = isset($_POST['worker_works_done']) ?['state' => 'free'] : $_SESSION['user_delivery'] ;

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
