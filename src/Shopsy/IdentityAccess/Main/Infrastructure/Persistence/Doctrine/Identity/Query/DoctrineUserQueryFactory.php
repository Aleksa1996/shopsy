<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Persistence\Doctrine\Identity\Query;

use App\Shopsy\IdentityAccess\Main\Domain\UserQueryFactory;

class DoctrineUserQueryFactory implements UserQueryFactory
{
    /**
     * @inheritDoc
     */
    public function id($id)
    {
        return new DoctrineUserIdQuery($id);
    }

    /**
     * @inheritDoc
     */
    public function filter($filter, $pagination = null, $sort = null)
    {
        return new DoctrineUserFilterQuery($filter, $sort);
    }

    /**
     * @inheritDoc
     */
    public function filterCollection($filter, $pagination = null, $sort = null)
    {
        return new DoctrineUserFilterCollectionQuery($filter, $pagination, $sort);
    }
}
