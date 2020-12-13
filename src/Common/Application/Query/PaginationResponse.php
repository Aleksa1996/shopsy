<?php

namespace App\Common\Application\Query;


class PaginationResponse extends Pagination
{
    /**
     * @var int
     */
    protected $totalItems;

    /**
     * Pagination constructor
     *
     * @param integer $totalItems
     * @param integer $page
     * @param integer $limit
     */
    public function __construct($totalItems, $page = 1, $limit = 10)
    {
        parent::__construct($page, $limit);
        $this->totalItems = $totalItems;
    }

    /**
     * @return  int
     */
    public function geTotalItems()
    {
        return $this->totalItems;
    }

    /**
     * @return  int
     */
    public function getfirstPage()
    {
        return 1;
    }

    /**
     * @return  int
     */
    public function getLastPage()
    {
        return ceil($this->totalItems / $this->limit);
    }

    /**
     * @return  int
     */
    public function getNextPage()
    {
        return $this->page >= $this->getLastPage() ? $this->getLastPage() : $this->page + 1;
    }
}
