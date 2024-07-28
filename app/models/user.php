<?php

class User extends Orm{
    public function __construct(mysqli $conn) {
        parent::__construct('usuario_id', 'usuarios', $conn);
    }
    
    public function auth($data) {
        $username = $data['usuario_alias'];
        $query = "SELECT * FROM $this->table WHERE usuario_alias = '$username' OR usuario_correo = '$username'";
        $result = $this->db->query($query);

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (md5($data["usuario_contraseña"]) === $user["usuario_contraseña"]) {
                // Variables de sesión de usuarios
                $_SESSION["usuario_id"] = $user["usuario_id"];
                $_SESSION["usuario_nombre"] = $user["usuario_nombre"];
                $_SESSION["usuario_apellido"] = $user["usuario_apellido"];
                $_SESSION["usuario_correo"] = $user["usuario_correo"];
                $_SESSION["usuario_alias"] = $user["usuario_alias"];
                $_SESSION["usuario_telefono"] = $user["usuario_telefono"];
                $_SESSION["rol_id"] = $user["rol_id"];

                $_SESSION["carrito"] = array();
                $_SESSION["usuario_informacion"] = ['estado' => 'libre'];

                return ['success' => true, 'message' => 'La inserción se realizó correctamente.'];
            } else {
                return ['success' => false, 'message' => 'La contraseña no coincide.'];
            }
        } else {
            return ['success' => false, 'message' => 'No se encuentra el usuario/correo.'];
        }
    }

    public function auth_google($data) {
        $data = [
            'usuario_correo' => $data['email'],
            'usuario_nombre' => $data['given_name'],
            'usuario_apellido' => $data['family_name'],
            'usuario_alias' => explode(" ", $data['given_name'])[0] . '_' . explode(" ", $data['family_name'])[0],
            'usuario_imagen_url' => $data['picture'],
        ];

        // verificar si existe un suaurio con ese correo
        $query = "SELECT * FROM $this->table WHERE usuario_correo = '" . $data['usuario_correo'] . "'";
        $result = $this->db->query($query);

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION["usuario_id"] = $user["usuario_id"];
            $_SESSION["usuario_nombre"] = $user["usuario_nombre"];
            $_SESSION["usuario_apellido"] = $user["usuario_apellido"];
            $_SESSION["usuario_correo"] = $user["usuario_correo"];
            $_SESSION["usuario_alias"] = $user["usuario_alias"];
            $_SESSION["usuario_telefono"] = $user["usuario_telefono"];
            $_SESSION["rol_id"] = $user["rol_id"];

            $_SESSION["carrito"] = array();
            $_SESSION["usuario_informacion"] = ['estado' => 'libre'];

            return ['success' => true, 'message' => 'La inserción se realizó correctamente.'];
        } else {
            $result = $this -> insert($data);

            if ($result['success']) {
                $user = $this -> getById($result['last_id']);
                
                $_SESSION["usuario_id"] = $user["usuario_id"];
                $_SESSION["usuario_nombre"] = $user["usuario_nombre"];
                $_SESSION["usuario_apellido"] = $user["usuario_apellido"];
                $_SESSION["usuario_correo"] = $user["usuario_correo"];
                $_SESSION["usuario_alias"] = $user["usuario_alias"];
                $_SESSION["usuario_telefono"] = $user["usuario_telefono"];
                $_SESSION["rol_id"] = $user["rol_id"];

                $_SESSION["carrito"] = array();
                $_SESSION["usuario_informacion"] = ['estado' => 'libre'];

                return ['success' => true, 'message' => 'La inserción se realizó correctamente.'];
            }
        }
    }
}
