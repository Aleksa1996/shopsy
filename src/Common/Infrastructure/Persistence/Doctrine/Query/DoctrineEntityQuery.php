<?php

namespace App\Common\Infrastructure\Persistence\Doctrine\Query;


abstract class DoctrineEntityQuery extends DoctrineQuery
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
