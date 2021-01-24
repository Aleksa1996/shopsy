<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Persistence\Doctrine\Access\Query;

use App\Common\Infrastructure\Persistence\Doctrine\Query\DoctrineEntityQuery;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;

class DoctrineByIdRoleQuery extends DoctrineEntityQuery
{
    /**
     * @var int|string
     */
    private $id;

    /**
     * DoctrineByIdRoleQuery Constructor
     *
     * @param int|string $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function criteria()
    {
        return Criteria::create()->where(new Comparison('id', Comparison::EQ,  $this->id));
    }
}
