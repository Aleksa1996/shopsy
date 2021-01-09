<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Transformer;

use App\Shopsy\IdentityAccess\Main\Application\Dto\UserDto;

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
                $user->getAvatar() === null ? null : $user->getAvatar()->getAvatar(),
                $user->getActive() === null ? null : $user->getActive()->getActive(),
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
