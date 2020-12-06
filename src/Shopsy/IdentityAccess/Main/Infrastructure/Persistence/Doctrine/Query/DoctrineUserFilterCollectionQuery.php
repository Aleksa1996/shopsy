<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Persistence\Doctrine\Query;

use Doctrine\Common\Collections\Criteria;

class DoctrineUserFilterCollectionQuery extends DoctrineUserCollectionQuery
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
        'email',
        'created_on',
        'updated_on',
        'full_name',
        'username'
    ];

    /**
     * DoctrineUserFilterCollectionQuery Constructor
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
