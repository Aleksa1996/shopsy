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
    private $total;

    /**
     * DtoCollection Constructor
     *
     * @param array $data
     * @param int $total
     * @param int $page
     * @param int $limit
     */
    public function __construct($data, $total, $page, $limit)
    {
        $this->data = $data;
        $this->total = $total;
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
        return ceil($this->total / $this->limit);
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
     * Get the value of total
     *
     * @return  int
     */
    public function getTotal()
    {
        return $this->total;
    }
}
