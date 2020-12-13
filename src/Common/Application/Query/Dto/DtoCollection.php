<?php

namespace App\Common\Application\Query\Dto;

use App\Common\Application\Query\PaginationResponse;

class DtoCollection
{
    /**
     * @var mixed
     */
    protected $data;

    /**
     * @var PaginationResponse
     */
    protected $pagination;

    /**
     * @var array
     */
    protected $meta;

    /**
     * DtoCollection Constructor
     *
     * @param array $data
     * @param PaginationResponse $pagination
     * @param array $meta
     */
    public function __construct($data, $pagination = null, $meta = [])
    {
        $this->data = $data;
        $this->pagination = $pagination;
        $this->meta = $meta;
    }

    /**
     * @return  mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return PaginationResponse
     */
    public function getPagination()
    {
        return $this->pagination;
    }

    /**
     * @return array
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * @return array
     */
    public function getPaginationMeta()
    {
        if ($this->pagination && $this->pagination instanceof PaginationResponse) {
            return [
                'totalPages' => $this->pagination->getLastPage(),
                'totalItems' => $this->pagination->geTotalItems()
            ];
        }

        return [];
    }

    /**
     * @return array
     */
    public function getFullMeta()
    {
        return $this->getMeta() + $this->getPaginationMeta();
    }
}
