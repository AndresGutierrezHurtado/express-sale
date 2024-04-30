<?php

class User extends Orm{
    public function __construct(mysqli $conn) {
        parent::__construct('user_id', 'users', $conn);
    }
    
    public function auth($data) {
        $username = $data['username'];
        $query = "SELECT * FROM $this->table WHERE username = '$username' OR email = '$username'";
        $result = $this->db->query($query);

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if ($data["password"] == $user["password"]) {
                $_SESSION["user_id"] = $user["user_id"];
                $_SESSION["full_name"] = $user["full_name"];
                $_SESSION["username"] = $user["username"];
                $_SESSION["email"] = $user["email"];
                $_SESSION["role_id"] = $user["role_id"];
                $_SESSION["cart"] = array();

                return ['success' => true, 'message' => 'La inserción se realizó correctamente.'];
            } else {
                return ['success' => false, 'message' => 'La contraseña no coincide.'];
            }
        } else {
            return ['success' => false, 'message' => 'No se encuentra el usuario/correo.'];
        }
    }
}
