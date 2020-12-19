<?php

namespace App\Shopsy\IdentityAccess\Main\Domain\Service;


class AuthenticationResponse
{
    /**
     * @var bool
     */
    private $success;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var AccessToken
     */
    private $accessToken;

    /**
     * @var RefreshToken
     */
    private $refreshToken;

    /**
     * @var \Exception
     */
    private $exception;

    /**
     * AuthenticationResponse Constructor
     *
     * @param bool $success
     * @param Client $client
     * @param AccessToken $accessToken
     * @param RefreshToken $refreshToken
     * @param \Exception $exception
     */
    public function __construct($success, $client = null, $accessToken = null, $refreshToken = null, $exception = null)
    {
        $this->success = $success;
        $this->client = $client;
        $this->accessToken = $accessToken;
        $this->refreshToken = $refreshToken;
        $this->exception = $exception;
    }

    /**
     * Get the value of success
     *
     * @return  bool
     */
    public function getSuccess()
    {
        return $this->success;
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

    /**
     * @return  \Exception
     */
    public function getException()
    {
        return $this->exception;
    }
}
