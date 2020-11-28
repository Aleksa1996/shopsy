<?php

namespace App\Common\Infrastructure\Application\Query;


class Pagination
{
    /**
     * Result page
     *
     * @var int
     */
    protected $page;

    /**
     * Limit the number of results
     *
     * @var int
     */
    protected $limit;

    /**
     * Offset
     *
     * @var int
     */
    protected $offset;

    /**
     * Pagination constructor
     *
     * @param integer $page
     * @param integer $limit
     */
    public function __construct($page = 1, $limit = 10)
    {
        $this->page = $page <= 0 ? 1 : $page;
        $this->limit = $limit > 500 ? 500 : $limit;
        $this->offset = ($this->page - 1) * $limit;
    }

    /**
     * Get page
     *
     * @return  int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Get limit
     *
     * @return  int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Get offset
     *
     * @return  int
     */
    public function getOffset()
    {
        return $this->offset;
    }
}
