<?php

namespace App\Shopsy\IdentityAccess\Infrastructure\Persistence\Doctrine\Query;

use Doctrine\Common\Collections\Criteria;

class DoctrineUserAllCollectionQuery extends DoctrineUserCollectionQuery
{
    /**
     * @return mixed
     */
    public function criteria()
    {
        return Criteria::create();
    }
}
