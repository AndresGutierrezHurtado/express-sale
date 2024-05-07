<?php

class User extends Orm{
    public function __construct(mysqli $conn) {
        parent::__construct('user_id', 'users', $conn);
    }
    
    public function auth($data) {
        $username = $data['user_username'];
        $query = "SELECT * FROM $this->table WHERE user_username = '$username' OR user_email = '$username'";
        $result = $this->db->query($query);

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if ($data["user_password"] == $user["user_password"]) {
                $_SESSION["user_id"] = $user["user_id"];
                $_SESSION["user_full_name"] = $user["user_full_name"];
                $_SESSION["user_username"] = $user["user_username"];
                $_SESSION["user_email"] = $user["user_email"];
                $_SESSION["user_role_id"] = $user["user_role_id"];
                $_SESSION["user_phone_number"] = $user["user_phone_number"];
                $_SESSION["user_cart"] = array();

                return ['success' => true, 'message' => 'La inserción se realizó correctamente.'];
            } else {
                return ['success' => false, 'message' => 'La contraseña no coincide.'];
            }
        } else {
            return ['success' => false, 'message' => 'No se encuentra el usuario/correo.'];
        }
    }
}
