<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Persistence\Doctrine\Query;

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
