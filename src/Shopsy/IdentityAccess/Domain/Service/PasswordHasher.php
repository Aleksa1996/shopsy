<?php


namespace App\Shopsy\IdentityAccess\Domain\Service;


interface PasswordHasher
{
    /**
     * @param $password
     *
     * @return string
     */
    public function hash($password);

    /**
     * @param $password
     * @param $hash
     *
     * @return bool
     */
    public function verify($password, $hash);
}