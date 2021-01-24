<?php

namespace App\Common\Infrastructure\Persistence\Doctrine\Query;


use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;

abstract class DoctrineQuery
{
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
     * @var Sort
     */
    protected $sort;

    /**
     * @var array
     */
    protected $supportedFields = [];

    /**
     * DoctrineQuery Constuctor
     *
     * @param Sort $sort
     */
    public function __construct($sort = null)
    {
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

        return $criteria;
    }

    /**
     * @return Sort
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @param Criteria $criteria
     * @param array $filter
     * @param string $expression
     */
    protected function addExpressions(Criteria $criteria, $filter, $expression = 'and')
    {
        $method = $expression === 'or' ? 'orWhere' : 'andWhere';

        if (is_array($filter) && count($filter)) {
            foreach ($filter as $filterKey => $filterValue) {
                if (strtolower($filterKey) === 'or') {
                    $this->addExpressions($criteria, $filterValue, 'or');
                } else if (strtolower($filterKey) === 'and') {
                    $this->addExpressions($criteria, $filterValue, 'and');
                } else if (in_array($filterKey, $this->supportedFields, true)) {
                    if (is_array($filterValue)) {
                        foreach ($filterValue as $o => $value) {
                            $criteria->$method(new Comparison($filterKey, self::SUPPORTED_OPERATORS[$o] ?? Comparison::EQ, $value));
                        }
                    } else {
                        $criteria->$method(new Comparison($filterKey, Comparison::EQ, $filterValue));
                    }
                } else if (is_array($filterValue)) {
                    $this->addExpressions($criteria, $filterValue, $expression);
                }
            }
        }
    }
}
