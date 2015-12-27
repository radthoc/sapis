<?php

namespace AppBundle\Service;

use AppBundle\Interfaces\DBWrapper;

class DBHandler
{
    private $dbWrapper;
    
    public function __construct($dbWrapper)
    {
        $this->dbWrapper = $dbWrapper;
    }
    
    public function findAll($table)
    {
        return $this->dbWrapper->getResults($table);
    }
    
    public function find($table, $params)
    {
        return $this->dbWrapper->getResults($table, $params);
    }
    
    public function persist($table, array $params, $id = null)
    {
        if (empty($params)) {
            throw new \Exception("Missing parameters", 400);
        }

        if (empty($id)) {
            return $this->dbWrapper->insert($table, $params);
        }
        
        $where = ['id' => $id];
        
        return $this->dbWrapper->update($table, $params, $where);
    }
}
