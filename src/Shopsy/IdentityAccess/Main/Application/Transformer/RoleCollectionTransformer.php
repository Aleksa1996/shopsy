<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Transformer;

interface RoleCollectionTransformer
{
    /**
     * @param mixed $roles
     *
     * @return mixed
     */
    public function write($roles);

    /**
     * @return mixed
     */
    public function read();
}
