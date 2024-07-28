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

    // CREATE
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
    
            
        $result = $this->db->query($query);
        $inserted_id = $this->db->insert_id;
        if ($result) {
            return ['success' => true, 'message' => 'La inserción se realizó correctamente.', 'last_id' => $inserted_id];
        } else {
            return ['success' => false, 'message' => 'Error al insertar los datos.'];
        }
    }

    // READ
    public function getAll($select = "*", $inner_join = "", $custom_query = "") {
        $query = "SELECT $select FROM $this->table $inner_join $custom_query";
        $result = $this->db->query($query);

        return $result -> fetch_all(MYSQLI_ASSOC);
    }
    
    public function getById($id, $select = "*", $inner_join = "", $custom_query = "") {
        $query = "SELECT $select FROM $this->table $inner_join WHERE $this->table.$this->id = $id $custom_query";
        $result = $this->db->query($query);

        return $result -> fetch_assoc();
    }

    // UPDATE    
    public function updateById($id, $data, $inner_join = "") {
        $query = "UPDATE $this->table $inner_join SET ";
        foreach ($data as $key => $value) {
            if (is_int($value)) {
                $query .= "$key = $value,";
            } else {
                $query .= "$key = '$value',";
            }           
        }
        $query = rtrim($query, ',');        
        $query .= " WHERE $this->table.$this->id = $id";
        
        $result = $this->db->query($query);

        if ($result) {
            return ['success' => true, 'message' => 'La actualización se realizó correctamente.', 'data' => $this -> getById($this -> db -> insert_id)];
        } else {
            return ['success' => false, 'message' => 'Error al actualizar los datos: ' . $this->db->error];
        }
    }

    // DELETE
    public function deleteById($id) {
        $query = "DELETE FROM $this->table WHERE $this->id = $id";
        $result = $this->db->query($query);

        if ($result) {
            return ["success"=> true, "message"=> "Elemento eliminado correctamente"];
        } else {
            return ["success"=> false, "message"=> "Error al eliminar el elemento: " . $this -> db -> error ];
        }
    }

    // PAGINATE
    public function paginate($page, $limit, $select = "*", $inner_join = "", $customQueryRows = "", $customQuery = "" ) {

        $offset = ($page - 1) * $limit;

        $rows = $this->db->query("SELECT COUNT(*) FROM $this->table $inner_join $customQueryRows") -> fetch_column();
        $result = $this->db->query("SELECT $select FROM $this->table $inner_join $customQuery LIMIT {$offset}, {$limit}") -> fetch_all(MYSQLI_ASSOC);
        $pages  = ceil($rows / $limit);

        
        return [
            'data' => $result,
            'page' => $page,
            'limit' => $limit,
            'pages' => $pages,
            'rows' => $rows,
        ];
    }

}