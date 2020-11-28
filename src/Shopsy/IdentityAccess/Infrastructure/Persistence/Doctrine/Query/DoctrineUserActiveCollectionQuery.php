<?php

namespace App\Shopsy\IdentityAccess\Infrastructure\Persistence\Doctrine\Query;

use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;

class DoctrineUserActiveCollectionQuery extends DoctrineUserCollectionQuery
{
    /**
     * @return mixed
     */
    public function criteria()
    {
        return Criteria::create()
            ->where(new Comparison('active', Comparison::EQ, true));
    }
}
