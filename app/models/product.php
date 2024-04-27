<?php

class Product extends Orm{
    public function __construct(mysqli $conn) {
        parent::__construct('id', 'products', $conn);
    }

    public function getByPrice($page, $limit, $filter, $min, $max){
        $offset = ($page - 1) * $limit;
        $rows = $this->db->query("SELECT COUNT(*) FROM $this->table WHERE $filter > $min AND $filter < $max") -> fetch_column();
        $query = "SELECT * FROM $this->table WHERE $filter > $min AND $filter < $max LIMIT {$offset}, {$limit}";
        $result = $this->db->query($query);

        $pages  = ceil($rows / $limit);
        $result = $result -> fetch_all(MYSQLI_ASSOC);
        
        return [
            'data' => $result,
            'page' => $page,
            'limit' => $limit,
            'pages' => $pages,
            'rows' => $rows,
        ];
    }

    public function getBySearch($page, $limit, $search){ 
        $offset = ($page - 1) * $limit;
        $rows = $this->db->query("SELECT COUNT(*) FROM $this->table WHERE name LIKE '%$search%' OR description LIKE '%$search%'") -> fetch_column();
        $query = "SELECT * FROM $this->table WHERE name LIKE '%$search%' OR description LIKE '%$search%' LIMIT {$offset}, {$limit}";
        $result = $this->db->query($query);

        $pages  = ceil($rows / $limit);
        $result = $result -> fetch_all(MYSQLI_ASSOC);
        
        return [
            'data' => $result,
            'page' => $page,
            'limit' => $limit,
            'pages' => $pages,
            'rows' => $rows,
        ];
        
    }
    
}
