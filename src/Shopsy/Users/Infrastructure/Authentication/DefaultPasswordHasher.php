<?php


namespace App\Shopsy\Users\Infrastructure\Authentication;


use App\Shopsy\Users\Domain\Model\PasswordHasher;

class DefaultPasswordHasher implements PasswordHasher
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