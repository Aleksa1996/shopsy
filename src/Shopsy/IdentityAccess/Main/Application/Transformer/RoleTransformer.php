<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Transformer;

use App\Shopsy\IdentityAccess\Main\Domain\Model\Access\Role;

interface RoleTransformer
{
    /**
     * @param Role $role
     *
     * @return mixed
     */
    public function write(Role $role);

    /**
     * @return mixed
     */
    public function read();
}
