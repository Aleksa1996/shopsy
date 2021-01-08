<?php

namespace App\Common\Infrastructure\Service\Hasher;

class BcryptHasher implements Hasher
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
