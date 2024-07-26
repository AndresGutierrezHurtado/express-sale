<?php

class calification extends Orm {

    public function __construct($conn) {
        parent::__construct('calificacion_id', 'calificaciones', $conn);
    }

    public function addCalification($data, $tabla) {

        $query = "INSERT INTO $tabla (";
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
}