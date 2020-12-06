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
     * @var Sort
     */
    protected $sort;

    /**
     * @var array
     */
    public const SUPPORTED_OPERATORS = [
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
     * @var array
     */
    protected $supportedFields = [];

    /**
     * DoctrineActiveUserQuery constructor
     *
     * @param Pagination $pagination
     * @param Sort $sort
     */
    public function __construct($pagination = null, $sort = null)
    {
        $this->pagination = $pagination;
        $this->sort = $sort;
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
        $criteria = $this->criteria();

        if (!is_null($this->sort)) {
            $criteria->orderBy(array_intersect_key($this->sort->getFields(), array_flip($this->supportedFields)));
        }

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

    /**
     * @return Sort
     */
    public function getSort()
    {
        return $this->sort;
    }
}
