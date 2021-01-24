<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Query;


class RoleQuery
{
    /**
     * @var array
     */
    private $filter;

    /**
     * @var array
     */
    private $sort;

    /**
     * RoleQuery constructor.
     *
     * @param array $filter
     * @param array $sort
     */
    public function __construct($filter, $sort = [])
    {
        $this->filter = $filter;
        $this->sort = $sort;
    }

    /**
     * @return  array
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * @return  array
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @return  array
     */
    public function getFilterKeys()
    {
        return array_keys($this->filter);
    }
}
