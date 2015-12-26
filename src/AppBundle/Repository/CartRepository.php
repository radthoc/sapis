<?php

namespace AppBundle\Repository;

use AppBundle\Service\DBHandler;

class CartRepository
{
    private $dbHandler;
    
    public function __construct(DBHandler $dbHandler)
    {
        $this->dbHandler = $dbHandler;
    }
    
    public function persist($row)
    {
        return $this->dbHandler->persist('cart', $row);
    }
}
