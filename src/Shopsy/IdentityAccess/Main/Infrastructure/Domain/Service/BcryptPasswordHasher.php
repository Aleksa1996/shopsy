<?php


namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Domain\Service;


use App\Shopsy\IdentityAccess\Main\Domain\Service\PasswordHasher;

class BcryptPasswordHasher implements PasswordHasher
{
    /**
     * @inheritDoc
     */
    public function hash($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * @inheritDoc
     */
    public function verify($password, $hash)
    {
        return password_verify($password, $hash);
    }

}