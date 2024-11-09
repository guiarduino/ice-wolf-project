<?php

namespace app\DAO;

class UserDAO extends Connection
{
    private $table = 'users';

    public function __construct()
    {
        parent::__construct($this->table);
    }

    public function getTable()
    {
        return $this->table;
    }

}