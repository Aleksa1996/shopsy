<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Query;


class RoleCollectionQuery
{
    /**
     * @var int
     */
    private $page;

    /**
     * @var int
     */
    private $limit;

    /**
     * @var array
     */
    private $filter;

    /**
     * @var array
     */
    private $sort;

    /**
     * RoleCollectionQuery constructor.
     *
     * @param int $page
     * @param int $limit
     * @param array $filter
     * @param array $sort
     */
    public function __construct($page, $limit, $filter = [], $sort = [])
    {
        $this->page = $page;
        $this->limit = $limit;
        $this->filter = $filter;
        $this->sort = $sort;
    }

    /**
     * @return  int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return  int
     */
    public function getLimit()
    {
        return $this->limit;
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
}
