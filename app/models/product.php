<?php

class Product {
    private $db, $conn;

    public function __construct($db) {
        $this->db = $db;
        $this->conn = $db->getConnection();
    }

    public function showProducts() {
        $query = "SELECT * FROM products";
        $result = $this->conn->query($query);
        

        if ($result->num_rows > 0) {
            $products = [];
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
            return $products;
        } else {
            return [];
        }
    }
}
