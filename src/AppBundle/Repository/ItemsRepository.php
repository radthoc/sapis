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

    public function persist(array $items)
    {
        if (array_key_exists('id', $items))
        {
            $id = $items['id'];
            array_pop($items);
            return $this->DBHandler->persist('items', $items, $id);
        }

        return $this->DBHandler->persist('items', $items);
    }
}