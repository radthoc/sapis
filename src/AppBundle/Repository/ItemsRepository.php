<?php

namespace AppBundle\Repository;

use AppBundle\Service\DBHandler;

class ItemsRepository
{
    private $dbHandler;
    
    public function __construct(DBHandler $dbHandler)
    {
        $this->dbHandler = $dbHandler;
    }
    
    public function find()
    {
        return [json_encode($this->dbHandler->findAll('items')), 'application/json'];
    }

    public function persist(array $items)
    {
        if (array_key_exists('id', $items)) {
            $id = $items['id'];
            array_pop($items);
            return $this->dbHandler->persist('items', $items, $id);
        }

        return $this->dbHandler->persist('items', $items);
    }
}
