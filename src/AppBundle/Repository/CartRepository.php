<?php

namespace AppBundle\Repository;

use AppBundle\Services\DBHandler;

class CartRepository {
    private $DBHandler;
    
    /*
    public function __construct(DBHandler $DBHandler)
    {
        $this->DBHandler = $DBHandler;
    }
    */

    public function add($row)
    {
        return $this->DBHandler->insert('cart', $row);
    }
}