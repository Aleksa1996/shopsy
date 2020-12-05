<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Query;

use App\Common\Application\Query\Query;

class UserCollectionQuery implements Query
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
     * UserQuery constructor.
     *
     * @param $fullName
     * @param $username
     * @param $email
     */
    public function __construct($page, $limit, $filter = [])
    {
        $this->page = $page;
        $this->limit = $limit;
        $this->filter = $filter;
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
}
