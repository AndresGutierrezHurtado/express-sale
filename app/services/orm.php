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
    
    public function insert() {
        
    }
}