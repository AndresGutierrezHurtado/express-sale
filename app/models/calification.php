<?php

class calification extends Orm {

    public function __construct($conn) {
        parent::__construct('calification_id', 'califications', $conn);
    }

}