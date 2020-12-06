<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Query;

use App\Common\Application\Query\Query;

class UserQuery implements Query
{
    /**
     * @var int|string
     */
    private $filter;

    /**
     * @var mixed
     */
    private $sort;

    /**
     * UserQuery constructor.
     *
     * @param array $filter
     * @param mixed $sort
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
     * @return  mixed
     */
    public function getSort()
    {
        return $this->sort;
    }
}
