<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Transformer;

use App\Shopsy\IdentityAccess\Main\Domain\Model\Access\Role;
use App\Shopsy\IdentityAccess\Main\Application\Dto\RoleDto;

class DtoRoleTransformer implements RoleTransformer
{
    /**
     * @var mixed
     */
    private $data;

    /**
     * @inheritDoc
     */
    public function write(Role $role)
    {
        $this->data = new RoleDto(
            $role->getId()->getId(),
            $role->getName(),
            $role->getIdentifier(),
            $role->getPermissions(),
            $role->getCreatedOn()->format(\DateTime::ATOM),
            $role->getUpdatedOn()->format(\DateTime::ATOM)
        );
    }

    /**
     * @inheritDoc
     */
    public function read()
    {
        return $this->data;
    }
}
