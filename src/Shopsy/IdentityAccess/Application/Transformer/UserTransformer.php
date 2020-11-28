<?php


namespace App\Shopsy\IdentityAccess\Application\Transformer;

use App\Shopsy\IdentityAccess\Domain\Model\User\User;

interface UserTransformer
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