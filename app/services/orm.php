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

    public function insert($data) {
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
    
                
        try {
            $result = $this->db->query($query);
            if ($result) {
                return ['success' => true, 'message' => 'La inserción se realizó correctamente.'];
            } else {
                return ['success' => false, 'message' => 'Error al insertar los datos.'];
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                return ['success' => false, 'message' => 'Error al insertar los datos: El usuario o correo ya existe'];
            } else {
                return ['success' => false, 'message' => 'Error al insertar los datos: ' . $e->getCode()];
            }
        }
    }

    public function getAll() {
        $query = "SELECT * FROM $this->table";
        $result = $this->db->query($query);

        return $result -> fetch_all(MYSQLI_ASSOC);
    }
    public function getById($id, $inner_join = "") {
        $query = "SELECT * FROM $this->table $inner_join WHERE $this->id = $id";
        $result = $this->db->query($query);

        return $result -> fetch_assoc();
    }
    
    public function updateById($id, $data) {
        $query = "UPDATE $this->table SET ";
        foreach ($data as $key => $value) {
            if (is_int($value)) {
                $query .= "$key = $value, ";
            } else {
                $query .= "$key = '$value' ,";
            }           
        }
        $query = rtrim($query, ',');        
        $query .= " WHERE $this->id = $id";   
        
        $result = $this->db->query($query);

        if ($result) {
            return ['success' => true, 'message' => 'La actualización se realizó correctamente.'];
        } else {
            return ['success' => false, 'message' => 'Error al actualizar los datos: ' . $this->db->error];
        }
    }

    public function deleteById($id) {
        $query = "DELETE FROM $this->table WHERE $this->id = $id";
        $result = $this->db->query($query);

        if ($result) {
            return ["success"=> true, "message"=> "Elemento eliminado correctamente"];
        } else {
            return ["success"=> false, "message"=> "Error al eliminar el elemento: " . $this -> db -> error ];
        }
    }

    public function paginate($page, $limit, $customQueryRows = "", $customQuery = "", $innerJoin = "") {

        $offset = ($page - 1) * $limit;

        $rows = $this->db->query("SELECT COUNT(*) FROM $this->table $customQueryRows") -> fetch_column();
        $result = $this->db->query("SELECT * FROM $this->table $innerJoin $customQuery LIMIT {$offset}, {$limit}") -> fetch_all(MYSQLI_ASSOC);
        $pages  = ceil($rows / $limit);
        
        return [
            'data' => $result,
            'page' => $page,
            'limit' => $limit,
            'pages' => $pages,
            'rows' => $rows,
        ];
    }

    public function autenticate($isAdmin) {
        if (!$isAdmin) {
            header("Location: /");
            exit();
        }        
    }
}