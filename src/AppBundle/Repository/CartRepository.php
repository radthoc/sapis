<?php

namespace AppBundle\Repository;

use AppBundle\Service\DBHandler;

class CartRepository
{
    private $DBHandler;
    
    public function __construct(DBHandler $DBHandler)
    {
        $this->DBHandler = $DBHandler;
    }
    
    public function persist($row)
    {
        return $this->DBHandler->persist('cart', $row);
    }
}
