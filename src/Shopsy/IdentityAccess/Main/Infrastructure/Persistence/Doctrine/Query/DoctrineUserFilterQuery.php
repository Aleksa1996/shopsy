<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Persistence\Doctrine\Query;

use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\Common\Collections\Expr\Expression;

class DoctrineUserFilterQuery extends DoctrineUserCollectionQuery
{
    /**
     * @var array
     */
    private $filter;

    /**
     * @var array
     */
    private $supportedFields = [
        'id',
        'email',
        'created_on',
        'updated_on',
        'full_name',
        'username'
    ];

    /**
     * DoctrineUserFilterQuery Constructor
     *
     * @param array $filter
     */
    public function __construct($filter, $pagination = null)
    {
        parent::__construct($pagination);
        $this->filter = $filter;
    }

    /**
     * @return mixed
     */
    public function criteria()
    {
        $criteria = Criteria::create();

        $this->addExpressions($criteria, $this->filter);

        return $criteria;
    }

    /**
     * @param Criteria $criteria
     * @param array $filter
     *
     * @return Expression
     */
    private function addExpressions(Criteria $criteria, array $filter, $expression = 'and')
    {
        $method = $expression === 'or' ? 'orWhere' : 'andWhere';

        if (count($filter)) {
            foreach ($filter as $filterKey => $filterValue) {
                if (strtolower($filterKey) === 'or') {
                    $this->addExpressions($criteria, $filterValue, 'or');
                } else if (strtolower($filterKey) === 'and') {
                    $this->addExpressions($criteria, $filterValue, 'and');
                } else if (in_array($filterKey, $this->supportedFields, true)) {
                    if (is_array($filterValue)) {
                        foreach ($filterValue as $o => $value) {
                            $criteria->$method(new Comparison($filterKey, $this->supportedOperators[$o] ?? Comparison::EQ, $value));
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
