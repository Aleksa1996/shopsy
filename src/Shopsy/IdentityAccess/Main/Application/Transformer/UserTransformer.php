<?php


namespace App\Shopsy\IdentityAccess\Main\Application\Transformer;

use App\Shopsy\IdentityAccess\Main\Domain\Model\User\User;

interface UserTransformer
{
    /**
     * @param User $user
     *
     * @return mixed
     */
    public function write($user);

    /**
     * @return mixed
     */
    public function read();
}