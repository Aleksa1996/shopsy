<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Persistence\Doctrine\Query;

use App\Shopsy\IdentityAccess\Main\Domain\UserQueryFactory;

class DoctrineUserQueryFactory implements UserQueryFactory
{
    /**
     * @inheritDoc
     */
    public function all($pagination = null)
    {
        return new DoctrineUserAllCollectionQuery($pagination);
    }

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
    public function username($username)
    {
        return new DoctrineUserUsernameQuery($username);
    }
}
