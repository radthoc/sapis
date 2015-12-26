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
    
    public function persist($table, array $variables, $id = null)
    {
        if (empty($variables)) {
            throw new \Exception("Missing parameters", 400);
        }

        if (empty($id))
        {
            return $this->dbWrapper->insert($table, $params);
        }
        
        $where = ['id' => $id];
        
        return $this->dbWrapper->update($table, $params, $where);
    }
}
