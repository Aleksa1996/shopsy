<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Transformer;

use App\Shopsy\IdentityAccess\Main\Domain\Model\Auth\AuthResponse;
use App\Shopsy\IdentityAccess\Main\Application\Dto\AuthResponseDto;

class DtoAuthTransformer implements AuthTransformer
{
    /**
     * @var mixed
     */
    private $data;

    /**
     * @inheritDoc
     */
    public function write(AuthResponse $authenticationResponse)
    {
        $this->data = new AuthResponseDto(
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
