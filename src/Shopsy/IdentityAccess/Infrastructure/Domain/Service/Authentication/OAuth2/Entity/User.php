<?php

namespace App\Shopsy\IdentityAccess\Infrastructure\Domain\Service\Authentication\OAuth2\Entity;

use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\UserEntityInterface;

class User implements UserEntityInterface
{
    /**
     * Return the user's identifier.
     *
     * @return mixed
     */
    public function getIdentifier()
    {
        return 1;
    }
}