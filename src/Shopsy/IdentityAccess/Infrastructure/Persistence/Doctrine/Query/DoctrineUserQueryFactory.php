<?php

namespace App\Shopsy\IdentityAccess\Infrastructure\Persistence\Doctrine\Query;

use App\Shopsy\IdentityAccess\Domain\UserQueryFactory;

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
