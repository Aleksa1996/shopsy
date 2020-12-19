<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Persistence\Doctrine\Identity\Query;


abstract class DoctrineUserQuery extends DoctrineQuery
{
    /**
     * @return mixed
     */
    public abstract function criteria();

    /**
     * @return mixed
     */
    public function toCriteria()
    {
        return parent::toCriteria()
            ->setMaxResults(1);
    }
}
