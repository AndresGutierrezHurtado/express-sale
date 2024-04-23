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
    
        // Ejecutar la consulta
        $result = $this->db->query($query);
        
        if ($result) {
            return ['success' => true, 'message' => 'La inserción se realizó correctamente.'];
        } else {
            return ['success' => false, 'message' => 'Error al insertar los datos: ' . $this->db->error];
        }
    }
    
}