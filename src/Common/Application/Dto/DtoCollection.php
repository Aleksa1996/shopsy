<?php

namespace App\Common\Application\Dto;


class DtoCollection
{
    /**
     * @var mixed
     */
    private $data;

    /**
     * @var int
     */
    private $page;

    /**
     * @var int
     */
    private $limit;

    /**
     * @var int
     */
    private $totalItems;

    /**
     * DtoCollection Constructor
     *
     * @param array $data
     * @param int $totalItems
     * @param int $page
     * @param int $limit
     */
    public function __construct($data, $totalItems, $page, $limit)
    {
        $this->data = $data;
        $this->totalItems = $totalItems;
        $this->page = $page;
        $this->limit = $limit;
    }

    /**
     * Get the value of data
     *
     * @return  mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get the value of page
     *
     * @return  int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Get the value of page
     *
     * @return  int
     */
    public function getNextPage()
    {
        return $this->page >= $this->getLastPage() ? $this->getLastPage() : $this->page + 1;
    }

    /**
     * Get the value of page
     *
     * @return  int
     */
    public function getfirstPage()
    {
        return 1;
    }

    /**
     * Get the value of page
     *
     * @return  int
     */
    public function getLastPage()
    {
        return ceil($this->totalItems / $this->limit);
    }

    /**
     * Get the value of limit
     *
     * @return  int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Get the value of totalItems
     *
     * @return  int
     */
    public function getTotalItems()
    {
        return $this->totalItems;
    }

    /**
     * Get the value of totalPages
     *
     * @return  int
     */
    public function getTotalPages()
    {
        return ceil($this->totalItems / $this->limit);
    }
}
