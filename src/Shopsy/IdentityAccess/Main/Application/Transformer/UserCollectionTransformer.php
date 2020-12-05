<?php


namespace App\Shopsy\IdentityAccess\Main\Application\Transformer;

use App\Shopsy\IdentityAccess\Main\Domain\Model\User\User;

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
