<?php


class Withdraw extends Orm
{

    public function __construct(PDO $conn)
    {
        parent::__construct('retiro_id', 'retiros', $conn);
    }
}
