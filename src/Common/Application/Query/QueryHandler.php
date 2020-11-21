<?php


namespace App\Common\Application\Query;


interface QueryHandler
{
    /**
     * @param $query
     *
     * @return mixed
     */
    public function execute($query = null);
}