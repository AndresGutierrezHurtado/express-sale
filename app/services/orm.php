<?php

class Orm {
    protected $id;
    protected $table;
    protected $db;

    public function __construct($id, $table, mysqli $conn) {
        $this->id = $id;
        $this->table = $table;
        $this->db = $conn;
    }

    public function getAll() {
        $query = "SELECT * FROM $this->table";
        $result = $this->db->query($query);
        return $result ->fetch_all(MYSQLI_ASSOC);
    }
    public function getById($id) {
        $query = "SELECT * FROM $this->table WHERE id = $id";
        $result = $this->db->query($query);
        return $result -> fetch_object();
    }

    public function updateById() {

    }

    public function deleteById($id) {
        $query = "DELETE FROM $this->table WHERE id = $id";
        $result = $this->db->query($query);
    }
    
    public function insert($data) {
        // Inicio de la construcción de la consulta SQL
        $query = "INSERT INTO $this->table (";
        foreach ($data as $key => $value) {
            $query .= "`$key`,";
        }
        $query = rtrim($query, ',');
        $query .= ') VALUES (';
        
        foreach ($data as $key => $value) {
            if (is_int($value)) {
                $query .= "$value, ";
            } else {
                $query .= "'" . addslashes($value) . "', ";
            }
        }
        $query = rtrim($query, ', ');
        $query .= ')';
    
        
        $result = $this->db->query($query);        
        if ($result) {
            return ['success' => true, 'message' => 'La inserción se realizó correctamente.'];
        } else {
            return ['success' => false, 'message' => 'Error al insertar los datos: ' . $this->db->error];
        }
    }

    public function auth($data) {
        $username = $data['username'];
        $query = "SELECT * FROM $this->table WHERE username = '$username' OR email = '$username'";
        $result = $this->db->query($query);

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if ($data["password"] == $user["password"]) {
                session_start();
                    $_SESSION["full_name"] = $user["full_name"];
                    $_SESSION["username"] = $user["username"];
                    $_SESSION["email"] = $user["email"];
                    $_SESSION["account_type"] = $user["account_type"];
                    $_SESSION["role_id"] = $user["role_id"];

                return ['success' => true, 'message' => 'La inserción se realizó correctamente.'];
            } else {
                return ['success' => false, 'message' => 'La contraseña no coincide.'];
            }
        } else {
            return ['success' => false, 'message' => 'No se encuentra el usuario/correo.'];
        }
    }
    
}