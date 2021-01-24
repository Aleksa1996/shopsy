<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Persistence\Doctrine\Access\Query;

use App\Shopsy\IdentityAccess\Main\Domain\RoleQueryFactory;


class DoctrineRoleQueryFactory implements RoleQueryFactory
{
    /**
     * @inheritDoc
     */
    public function byId($id)
    {
        return new DoctrineByIdRoleQuery($id);
    }

    /**
     * @inheritDoc
     */
    public function filter($filter, $pagination = null, $sort = null)
    {
        return new DoctrineRoleFilterQuery($filter, $sort);
    }

    /**
     * @inheritDoc
     */
    public function filterCollection($filter, $pagination = null, $sort = null)
    {
        return new DoctrineRoleFilterCollectionQuery($filter, $pagination, $sort);
    }
}
