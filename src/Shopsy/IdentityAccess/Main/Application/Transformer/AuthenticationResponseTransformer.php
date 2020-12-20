<?php


namespace App\Shopsy\IdentityAccess\Main\Application\Transformer;

use App\Shopsy\IdentityAccess\Main\Domain\Model\Auth\AuthenticationResponse;


interface AuthenticationResponseTransformer
{
    /**
     * @param AuthenticationResponse $user
     *
     * @return mixed
     */
    public function write(AuthenticationResponse $authenticationResponse);

    /**
     * @return mixed
     */
    public function read();
}
