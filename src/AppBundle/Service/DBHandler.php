<?php

namespace AppBundle\Service;

class DBHandler
{
    public function findAll($table)
    {
        return [
            0 => [
                'id' => 10,
                'name' => 'item 1',
                'description' => 'lorem ipsum...',
                'price' => 8.25
            ],
            1 => [
                'id' => 20,
                'name' => 'item 2',
                'description' => 'lorem ipsum...',
                'price' => 12.59
            ],
            2 => [
                'id' => 30,
                'name' => 'item 3',
                'description' => 'lorem ipsum...',
                'price' => 10.90
            ],
        ];
    }
    
    public function persist($table, array $variables, $id = null)
    {
        if (empty($variables)) {
            throw new \Exception("Missing parameters", 400);
        }

        if ($id) {
            return 40;
        }
        
        return true;
    }
}
