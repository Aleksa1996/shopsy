<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Persistence\Doctrine\Query;

use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;

class DoctrineUserIdQuery extends DoctrineUserQuery
{
    /**
     * @var int|string
     */
    private $id;

    /**
     * DoctrineUserIdQuery Constructor
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
