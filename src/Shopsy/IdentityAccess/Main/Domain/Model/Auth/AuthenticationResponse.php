<?php

namespace App\Shopsy\IdentityAccess\Main\Domain\Model\Auth;


class AuthenticationResponse
{
    /**
     * @var bool
     */
    private $success;

    /**
     * @var string
     */
    private $message;

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
     * AuthenticationResponse Constructor
     *
     * @param bool $success
     * @param string $message
     * @param string $tokenType
     * @param int $expiresIn
     * @param string $accessToken
     * @param string $refreshToken
     */
    public function __construct($success, $message, $tokenType = null, $expiresIn = null, $accessToken = null, $refreshToken = null)
    {
        $this->success = $success;
        $this->message = $message;
        $this->tokenType = $tokenType;
        $this->expiresIn = $expiresIn;
        $this->accessToken = $accessToken;
        $this->refreshToken = $refreshToken;
    }

    /**
     * @return  bool
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * @return  string
     */
    public function getMessage()
    {
        return $this->message;
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
     * @return  Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return  AccessToken
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @return  RefreshToken
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }
}
