<?php

namespace Repository;

use Config\Db;

/**
 *  CLASSE MERE / CONNEXION A LA BDD
 */
class Repository
{
    protected $db;
    public function __construct()
    {
        $this->db = new Db;
    }
}
