<?php

namespace AppBundle\Repository;

use AppBundle\Services\DBHandler;

class ItemsRepository {
    private $DBHandler;
    
    public function __construct(DBHandler $DBHandler)
    {
        $this->DBHandler = $DBHandler;
    }
    
    public function findAll()
    {
        return $this->DBHandler->findAll('items');
    }

    public function save($items)
    {
        if ($id = array_pop($items))
        {
            return $this->DBHandler->update('items', $id, $items);
        }
        return $this->DBHandler->insert('items', $items);
    }
}