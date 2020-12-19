<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Persistence\Doctrine\Identity\Query;

use Doctrine\Common\Collections\Criteria;

class DoctrineUserFilterQuery extends DoctrineUserQuery
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
     * DoctrineUserFilterQuery Constructor
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
