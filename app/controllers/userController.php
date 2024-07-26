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
        $_POST['usuario_contraseña'] = md5($_POST['usuario_contraseña']);
        
        $result = $this -> userModel -> insert($_POST);
    
        echo json_encode($result);
    }

    public function update() {
        $id = $_POST['usuario_id'];
        unset($_POST['usuario_id']);

        $_POST['usuario_direccion'] = $_POST['usuario_direccion'] == "" ? null : $_POST['usuario_direccion'];
        $_POST['usuario_telefono'] = $_POST['usuario_telefono'] == "" || $_POST['usuario_telefono'] == "0" ? null : $_POST['usuario_telefono'];

        // Verificar si se ha enviado una imagen
        if (!empty($_FILES['usuario_imagen']['name'])) {
            $_POST['usuario_imagen_url'] = '/public/images/users/' . $id . '.jpg';

            move_uploaded_file($_FILES['usuario_imagen']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $_POST['usuario_imagen_url']);
        }
        
        $result = $this -> userModel -> updateById($id, $_POST, "INNER JOIN trabajadores ON usuarios.usuario_id = trabajadores.usuario_id");
        
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
