<?php

namespace App\Service;

class DBHandler
{
    public function findAll($table)
    {
        return [
            ['id' => 1, 'name' => 'item1'],
            ['id' => 2, 'name' => 'item2'],
            ['id' => 3, 'name' => 'item3'],
        ];
    }

    public function insert( $table, $variables = array() )
    {
        if( empty( $variables ) )
        {
            throw new Exception("Some error message", 400);
        }

        return true;
    }
    
    public function udate( $table, $id, $variables = array() )
    {
        if( empty($variables) || empty($id))
        {
            throw new Exception("Some error message", 400);
        }

        return true;
    }
}