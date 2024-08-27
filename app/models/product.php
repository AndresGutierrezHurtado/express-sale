<?php

class Product extends Orm
{
    private $calificationModel;
    private $multimediaModel;

    public function __construct(PDO $conn)
    {
        parent::__construct('producto_id', 'productos', $conn);
        $this->calificationModel = new calification($conn);
        $this->multimediaModel = new Multimedia($conn);
    }

    public function getProduct($id)
    {

        $product = $this->getById(
            $id,
            "productos.*, usuarios.usuario_alias,
            COUNT(calificaciones_productos.producto_id) AS numero_calificaciones,
            ROUND(IFNULL(AVG(calificaciones.calificacion), 0), 2) AS calificacion_promedio,
            COUNT(CASE WHEN calificaciones.calificacion = 1 THEN 1 END) AS calificaciones_1,
            COUNT(CASE WHEN calificaciones.calificacion = 2 THEN 1 END) AS calificaciones_2,
            COUNT(CASE WHEN calificaciones.calificacion = 3 THEN 1 END) AS calificaciones_3,
            COUNT(CASE WHEN calificaciones.calificacion = 4 THEN 1 END) AS calificaciones_4,
            COUNT(CASE WHEN calificaciones.calificacion = 5 THEN 1 END) AS calificaciones_5 ",
            "INNER JOIN usuarios ON productos.usuario_id = usuarios.usuario_id
            LEFT JOIN calificaciones_productos ON calificaciones_productos.producto_id = productos.producto_id
            LEFT JOIN calificaciones ON calificaciones.calificacion_id = calificaciones_productos.calificacion_id"
        );

        $product['calificaciones'] = $this->calificationModel->getAll(
            "*",
            "INNER JOIN calificaciones_productos ON calificaciones.calificacion_id = calificaciones_productos.calificacion_id
            INNER JOIN usuarios ON calificaciones.usuario_id = usuarios.usuario_id",
            "WHERE calificaciones_productos.producto_id = " . $product['producto_id']
        );

        $product['multimedia'] = $this->multimediaModel->getAll("*", "", "WHERE producto_id = " . $product['producto_id']);

        return $product;
    }
}
