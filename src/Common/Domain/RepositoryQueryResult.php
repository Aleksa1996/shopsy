<?php

namespace App\Common\Domain;


class RepositoryQueryResult
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @var int
     */
    protected $count;

    /**
     * RepositoryQueryResult Constructor
     *
     * @param array $data
     * @param int $count
     */
    public function __construct($data, $count = null)
    {
        $this->data = $data;
        $this->count = $count;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return  int
     */
    public function getCount()
    {
        return $this->count;
    }
}
