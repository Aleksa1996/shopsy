<?php


namespace App\Shopsy\Users\Application\DataTransformer;


use App\Shopsy\Users\Domain\Model\User;

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