<?php

namespace AppBundle\Interfaces;

interface DBWrapper
{
    public function getRow($table, $params = []);

    public function getResults($query, $params = []);

    public function insert($table, $params);

    public function update($table, $variables, $where, $limit = '');

    public function lastid();

    public function affectedRows();
}