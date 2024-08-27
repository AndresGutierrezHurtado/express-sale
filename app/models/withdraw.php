<?php


class Withdraw extends Orm
{

    public function __construct(mysqli $conn)
    {
        parent::__construct('retiro_id', 'retiros', $conn);
    }
}
