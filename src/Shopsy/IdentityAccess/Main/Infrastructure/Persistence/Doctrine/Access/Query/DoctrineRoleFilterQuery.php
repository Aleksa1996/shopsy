<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Persistence\Doctrine\Access\Query;

use App\Common\Infrastructure\Persistence\Doctrine\Query\DoctrineEntityQuery;
use Doctrine\Common\Collections\Criteria;

class DoctrineRoleFilterQuery extends DoctrineEntityQuery
{
    /**
     * @var array
     */
    private $filter;

    /**
     * @var array
     */
    protected $supportedFields = [
        'id',
        'name',
        'identifier',
        'createdOn',
        'updatedOn'
    ];

    /**
     * DoctrineRoleFilterQuery Constructor
     *
     * @param array $filter
     * @param Sort $sort
     */
    public function __construct($filter, $sort = null)
    {
        parent::__construct($sort);
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
}
