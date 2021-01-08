<?php


namespace App\Shopsy\IdentityAccess\Main\Application\Transformer;

use App\Shopsy\IdentityAccess\Main\Domain\Model\Auth\AuthResponse;


interface AuthTransformer
{
    /**
     * @param AuthResponse $user
     *
     * @return mixed
     */
    public function write(AuthResponse $authenticationResponse);

    /**
     * @return mixed
     */
    public function read();
}
