<?php

namespace App\Common\Infrastructure\Persistence\Doctrine\Query;


abstract class DoctrineEntityCollectionQuery extends DoctrineQuery
{
    /**
     * @var Pagination
     */
    protected $pagination;

    /**
     * DoctrineActiveEntityQuery constructor
     *
     * @param Pagination $pagination
     * @param Sort $sort
     */
    public function __construct($pagination = null, $sort = null)
    {
        parent::__construct($sort);
        $this->pagination = $pagination;
    }

    /**
     * @return mixed
     */
    public function toCriteria()
    {
        $criteria = parent::toCriteria();

        if (!is_null($this->pagination)) {
            $criteria
                ->setFirstResult($this->pagination->getOffset())
                ->setMaxResults($this->pagination->getLimit());
        }

        return $criteria;
    }

    /**
     * @return  Pagination
     */
    public function getPagination()
    {
        return $this->pagination;
    }
}
