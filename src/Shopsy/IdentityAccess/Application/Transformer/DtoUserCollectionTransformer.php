<?php

namespace App\Shopsy\IdentityAccess\Application\Transformer;

use App\Shopsy\IdentityAccess\Application\Dto\UserDto;

class DtoUserCollectionTransformer implements UserCollectionTransformer
{
    /**
     * @var mixed
     */
    private $data;

    /**
     * @inheritDoc
     */
    public function write($users)
    {
        foreach ($users as $user) {
            $this->data[] = new UserDto(
                $user->getId()->getId(),
                $user->getFullName()->getFullName(),
                $user->getUsername()->getUsername(),
                $user->getEmail()->getEmail(),
                $user->getCreatedOn()->format(\DateTime::ATOM),
                $user->getUpdatedOn()->format(\DateTime::ATOM)
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function read()
    {
        return $this->data;
    }
}
