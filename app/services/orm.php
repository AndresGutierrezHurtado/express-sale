<?php

class Orm
{
    protected $id;
    protected $table;
    protected $db;

    public function __construct($id, $table, PDO $conn)
    {
        $this->id = $id;
        $this->table = $table;
        $this->db = $conn;
    }

    // CREATE
    public function insert($data)
    {
        try {

            $columns = implode(", ", array_keys($data));
            $placeholders = ":" . implode(" , :", array_keys($data));

            $sql = "INSERT INTO {$this->table} ( {$columns} ) VALUES ( {$placeholders} )";

            $stmt = $this->db->prepare($sql);

            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            $stmt->execute();

            $last_id = $this->db->lastInsertId();

            return ['success' => true, 'message' => 'La inserción se realizó correctamente.', 'last_id' => $last_id];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al insertar los datos.', 'error' => $e->getMessage()];
        }
    }

    // READ
    public function getAll($select = "*", $inner_join = "", $where = "", $order_by = "", $group_by = "")
    {
        try {

            $sql = "SELECT {$select} FROM {$this->table} {$inner_join}";

            if ($where) {
                $sql .= " WHERE {$where}";
            }

            if ($group_by) {
                $sql .= " GROUP BY {$group_by}";
            }

            if ($order_by) {
                $sql .= " ORDER BY {$order_by}";
            }

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al obtener los datos.', 'error' => $e->getMessage()];
        }
    }

    public function getById($id, $select = "*", $inner_join = "")
    {
        try {
            $sql = "SELECT {$select} FROM {$this->table} {$inner_join} WHERE {$this->table}.{$this->id} = :id";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al obtener los datos.', 'error' => $e->getMessage()];
        }
    }

    // UPDATE
    public function updateById($idValue, $data, $inner_join = "", $where = "")
    {
        try {
            $columns = "";
            foreach ($data as $key => $value) {
                $columns .= "$key = :$key, ";
            }
            $columns = rtrim($columns, ", ");

            $sql = "UPDATE {$this->table} {$inner_join} SET {$columns} WHERE {$this->table}.{$this->id} = :id";

            if ($where) {
                $sql .= " AND {$where}";
            }

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $idValue);

            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            $stmt->execute();

            return ['success' => true, 'message' => 'La actualización se realizó correctamente.'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al actualizar los datos.', 'error' => $e->getMessage()];
        }
    }

    // DELETE
    public function deleteById($idValue)
    {
        try {
            $sql = "DELETE FROM {$this->table} WHERE {$this->id} = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $idValue);
            $stmt->execute();

            return ['success' => true, 'message' => 'La eliminación se realizó correctamente.'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al borrar los datos.', 'error' => $e->getMessage()];
        }
    }

    // PAGINATE
    public function paginate($page, $limit, $select = "*", $inner_join = "", $where = "", $order_by = "", $group_by = "")
    {
        try {

            $offset = ($page - 1) * $limit;

            // Construir la consulta para contar las filas totales
            $countSql = "SELECT COUNT(*) FROM {$this->table} {$inner_join}";

            if ($where) {
                $countSql .= " WHERE {$where}";
            }

            $countStmt = $this->db->prepare($countSql);
            $countStmt->execute();
            $rows = $countStmt->fetchColumn();

            // Construir la consulta principal con los datos seleccionados y limitación
            $sql = "SELECT {$select} FROM {$this->table} {$inner_join}";

            if ($where) {
                $sql .= " WHERE {$where}";
            }

            if ($group_by) {
                $sql .= " GROUP BY {$group_by}";
            }

            if ($order_by) {
                $sql .= " ORDER BY {$order_by}";
            }

            $sql .= " LIMIT :offset, :limit";


            $dataStmt = $this->db->prepare($sql);
            $dataStmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
            $dataStmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $dataStmt->execute();
            $result = $dataStmt->fetchAll(PDO::FETCH_ASSOC);

            // Calcular el número total de páginas
            $pages = ceil($rows / $limit);

            // Retornar la respuesta paginada
            return [
                'data' => $result,
                'page' => $page,
                'limit' => $limit,
                'pages' => $pages,
                'rows' => $rows,
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al obtener los datos.', 'error' => $e->getMessage()];
        }
    }
}
