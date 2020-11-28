<?php


namespace App\Shopsy\IdentityAccess\Application\Transformer;

use App\Shopsy\IdentityAccess\Domain\Model\User\User;

interface UserCollectionTransformer
{
    /**
     * @param User[] $users
     *
     * @return mixed
     */
    public function write($users);

    /**
     * @return mixed
     */
    public function read();
}
