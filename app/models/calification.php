<?php

class calification extends Orm {

    public function __construct($conn) {
        parent::__construct('calificacion_id', 'calificaciones', $conn);
    }

}