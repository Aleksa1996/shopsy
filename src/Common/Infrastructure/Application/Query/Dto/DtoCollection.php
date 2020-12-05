<?php

namespace App\Common\Infrastructure\Application\Query\Dto;

use App\Common\Infrastructure\Application\Query\TraversablePagination;

class DtoCollection
{
    /**
     * @var mixed
     */
    protected $data;

    /**
     * @var TraversablePagination
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
     * @param TraversablePagination $pagination
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
     * @return TraversablePagination
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
        if ($this->pagination && $this->pagination instanceof TraversablePagination) {
            return [
                'totalPages' => $this->pagination->getLastPage(),
                'totalItems' => $this->pagination->geTotalItems()
            ];
        }

        return [];
    }
}
