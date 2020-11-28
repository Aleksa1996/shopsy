<?php

namespace App\Shopsy\IdentityAccess\Infrastructure\Persistence\Doctrine\Query;


abstract class DoctrineUserQuery
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
        return $this->criteria()
            ->setMaxResults(1);
    }
}
