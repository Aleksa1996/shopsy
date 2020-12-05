<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Persistence\Doctrine\Query;


abstract class DoctrineUserCollectionQuery
{
    /**
     * @var Pagination
     */
    protected $pagination;

    /**
     * DoctrineActiveUserQuery constructor
     *
     * @param Pagination $pagination
     */
    public function __construct($pagination = null)
    {
        $this->pagination = $pagination;
    }

    /**
     * @return mixed
     */
    public abstract function criteria();

    /**
     * @return mixed
     */
    public function toCriteria()
    {
        return $this->criteria()
            ->setFirstResult($this->pagination->getOffset())
            ->setMaxResults($this->pagination->getLimit());
    }

    /**
     * @return  Pagination
     */
    public function getPagination()
    {
        return $this->pagination;
    }
}
