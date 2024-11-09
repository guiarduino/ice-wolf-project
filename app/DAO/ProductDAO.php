<?php

namespace app\DAO;

class ProductDAO extends Connection
{
    private $table = 'products';

    public function __construct()
    {
        parent::__construct($this->table);
    }

    public function getTable()
    {
        return $this->table;
    }

}