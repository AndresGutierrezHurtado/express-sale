<?php

class User extends Orm{
    public function __construct(mysqli $conn) {
        parent::__construct('user_id', 'users', $conn);
    }    
}
