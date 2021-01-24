<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Transformer;

use App\Shopsy\IdentityAccess\Main\Application\Dto\RoleDto;

class DtoRoleCollectionTransformer implements RoleCollectionTransformer
{
    /**
     * @var mixed
     */
    private $data;

    /**
     * @inheritDoc
     */
    public function write($roles)
    {
        foreach ($roles as $role) {
            $this->data[] = new RoleDto(
                $role->getId()->getId(),
                $role->getName(),
                $role->getIdentifier(),
                $role->getActive(),
                $role->getPermissions(),
                $role->getCreatedOn()->format(\DateTime::ATOM),
                $role->getUpdatedOn()->format(\DateTime::ATOM)
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
