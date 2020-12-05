<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Persistence\Doctrine\Query;

use Doctrine\Common\Collections\Expr\Comparison;

abstract class DoctrineUserCollectionQuery
{
    /**
     * @var Pagination
     */
    protected $pagination;

    /**
     * @var array
     */
    protected $supportedOperators = [
        'in' => Comparison::IN,
        'nin' => Comparison::NIN,
        'ct' => Comparison::CONTAINS,
        'bw' => Comparison::STARTS_WITH,
        'ew' => Comparison::ENDS_WITH,
        'eq' => Comparison::EQ,
        'neq' => Comparison::NEQ,
        'gt' => Comparison::GT,
        'gte' => Comparison::GTE,
        'lt' => Comparison::LT,
        'lte' => Comparison::LTE
    ];

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
        if (is_null($this->pagination)) {
            return $this->criteria();
        }

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
