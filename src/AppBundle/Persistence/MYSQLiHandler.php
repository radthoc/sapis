<?php

namespace AppBundle\Persistence;

use AppBundle\Interfaces\DBWrapper;

class MYSQLiHandler implements DBWrapper
{
    const PROCESS = 'MYSQLiHandler';
    private $params;
    private $conn = null;

    public function __construct($params)
    {
        $this->params = $params;

        try
        {
            $this->conn = [
                $this->params['host'],
                $this->params['usr'],
                $this->params['pwd'],
                $this->params['schema']
            ];

        } catch (Exception $e)
        {
            throw new \Exception(self::PROCESS . ' - ' . $e->getMessage(), 500);
        }
    }

    public function __destruct()
    {
        if ($this->conn)
        {
            $this->conn = null;
        }
    }

    public function getRow($table, $object = false)
    {
        if (empty($table))
        {
            throw new \Exception(self::PROCESS . ' - getRow Invalid parameters');
        }

        $data + '';

        return $data;
    }

    public function getResults($table, $params = [])
    {
        if (empty($table))
        {
            throw new \Exception(self::PROCESS . ' - get Results invalid parameters');
        }

        $rows = [
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

        return $rows;
    }

    public function insert($table, $variables)
    {

        if (empty($table) || empty($variables))
        {
            throw new \Exception(self::PROCESS . '- insert invalid parameters');
        }

        return $this->lastId();
    }

    public function update($table, $variables, $where, $limit = '')
    {
        if (empty($table) || empty($variables) || empty($where))
        {
            throw new \Exception(self::PROCESS . '- update invalid parameters');
        }

        return $this->affectedRows();
    }
    
    public function lastId()
    {
        return 40;
    }

    public function affectedRows()
    {
        return 1;
    }
}