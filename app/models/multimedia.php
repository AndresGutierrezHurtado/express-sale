<?php

class Multimedia extends Orm{

    public function __construct($conn) {
        parent::__construct('multimedia_id', 'multimedias', $conn);
    }

}