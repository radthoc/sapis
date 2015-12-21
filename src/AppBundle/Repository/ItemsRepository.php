<?php

namespace AppBundle\Repository;

use AppBundle\Service\DBHandler;

class ItemsRepository {
    private $DBHandler;
    
    public function __construct(DBHandler $DBHandler)
    {
        $this->DBHandler = $DBHandler;
    }
    
    public function find()
    {
        return [json_encode($this->DBHandler->findAll('items')), 'application/json'];
    }

    public function persist($items)
    {
        if ($id = array_pop($items))
        {
            return $this->DBHandler->update('items', $id, $items);
        }

        return $this->DBHandler->insert('items', $items);
    }
}