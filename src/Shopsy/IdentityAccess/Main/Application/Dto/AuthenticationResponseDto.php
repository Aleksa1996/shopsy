<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Dto;

use App\Common\Application\Query\Dto\Dto;

class AuthenticationResponseDto extends Dto
{
    /**
     * @var string
     */
    private $tokenType;

    /**
     * @var int
     */
    private $expiresIn;

    /**
     * @var string
     */
    private $accessToken;

    /**
     * @var string
     */
    private $refreshToken;

    /**
     * AuthDto Constructor
     *
     * @param int|string $id
     * @param string $fullName
     * @param string $username
     * @param string $email
     * @param bool $active
     * @param string $avatar
     * @param string $signature
     * @param string $createdOn
     * @param string $updatedOn
     */
    public function __construct($tokenType, $expiresIn, $accessToken, $refreshToken)
    {
        $this->tokenType = $tokenType;
        $this->expiresIn = $expiresIn;
        $this->accessToken = $accessToken;
        $this->refreshToken = $refreshToken;
    }

    /**
     * @return  string
     */
    public function getTokenType()
    {
        return $this->tokenType;
    }

    /**
     * @return  int
     */
    public function getExpiresIn()
    {
        return $this->expiresIn;
    }

    /**
     * @return  string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @return  string
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }
}
