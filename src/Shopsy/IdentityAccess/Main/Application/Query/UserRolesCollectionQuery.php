<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Query;


class UserRolesCollectionQuery
{
    /**
     * @var int|string
     */
    private $userId;

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
     * UserRolesCollectionQuery constructor.
     *
     * @param int|string $userId
     * @param int $page
     * @param int $limit
     * @param array $filter
     * @param array $sort
     */
    public function __construct($userId, $page, $limit, $filter = [], $sort = [])
    {
        $this->userId = $userId;
        $this->page = $page;
        $this->limit = $limit;
        $this->filter = $filter;
        $this->sort = $sort;
    }

    /**
     * @return  int|string
     */
    public function getUserId()
    {
        return $this->userId;
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
