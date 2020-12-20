<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Transformer;

use App\Shopsy\IdentityAccess\Main\Domain\Model\Auth\AuthenticationResponse;
use App\Shopsy\IdentityAccess\Main\Application\Dto\AuthenticationResponseDto;

class DtoAuthenticationResponseTransformer implements AuthenticationResponseTransformer
{
    /**
     * @var mixed
     */
    private $data;

    /**
     * @inheritDoc
     */
    public function write(AuthenticationResponse $authenticationResponse)
    {
        $this->data = new AuthenticationResponseDto(
            $authenticationResponse->getTokenType(),
            $authenticationResponse->getExpiresIn(),
            $authenticationResponse->getAccessToken(),
            $authenticationResponse->getRefreshToken()
        );
    }

    /**
     * @inheritDoc
     */
    public function read()
    {
        return $this->data;
    }
}
