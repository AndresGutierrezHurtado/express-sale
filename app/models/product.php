<?php

class Product extends Orm{
    public function __construct(mysqli $conn) {
        parent::__construct('id', 'products', $conn);
    }    

    public function getBySeller($page, $limit, $id) {
        $offset = ($page - 1) * $limit;
        $rows = $this->db->query("SELECT COUNT(*) FROM $this->table WHERE user_id = $id") -> fetch_column();
        $query = "SELECT * FROM $this->table LIMIT {$offset}, {$limit}";
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
