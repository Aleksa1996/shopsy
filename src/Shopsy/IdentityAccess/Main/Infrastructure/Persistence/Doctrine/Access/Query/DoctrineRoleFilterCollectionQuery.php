<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Persistence\Doctrine\Access\Query;

use App\Common\Infrastructure\Persistence\Doctrine\Query\DoctrineEntityCollectionQuery;
use Doctrine\Common\Collections\Criteria;

class DoctrineRoleFilterCollectionQuery extends DoctrineEntityCollectionQuery
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
     * DoctrineRoleFilterCollectionQuery Constructor
     *
     * @param array $filter
     * @param Pagination $pagination
     * @param Sort $sort
     */
    public function __construct($filter, $pagination = null, $sort = null)
    {
        parent::__construct($pagination, $sort);
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
