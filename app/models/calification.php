<?php

class calification extends Orm
{

    public function __construct($conn)
    {
        parent::__construct('calificacion_id', 'calificaciones', $conn);
    }

    public function insertCalification($data, $tabla)
    {
        try {
            $columns = implode(", ", array_keys($data));
            $placeholders = ":" . implode(", :", array_keys($data));

            $sql = "INSERT INTO {$tabla} ({$columns}) VALUES ({$placeholders})";
            $stmt = $this->db->prepare($sql);

            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            $stmt->execute();

            $last_id = $this->db->lastInsertId();

            return ['success' => true, 'message' => 'La inserción se realizó correctamente.', 'last_id' => $last_id];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al insertar los datos.'];
        }
    }
}
