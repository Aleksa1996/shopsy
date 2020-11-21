<?php


namespace App\Shopsy\IdentityAccess\Application\DataTransformer;


use App\Shopsy\IdentityAccess\Domain\Model\User;

interface UserDataTransformer
{
    /**
     * @param User $user
     *
     * @return mixed
     */
    public function write(User $user);

    /**
     * @return mixed
     */
    public function read();
}