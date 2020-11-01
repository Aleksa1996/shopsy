<?php


namespace App\Shopsy\Users\Infrastructure\Authentication\Oauth2\Repository;


use App\Shopsy\Users\Infrastructure\Authentication\Oauth2\Entity\AccessToken;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;

class AccessTokenRepository implements AccessTokenRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null)
    {
        $accessToken = new AccessToken();
        $accessToken->setClient($clientEntity);

        foreach ($scopes as $scope) {
            $accessToken->addScope($scope);
        }
        $accessToken->setUserIdentifier($userIdentifier);

        return $accessToken;
    }

    /**
     * @inheritDoc
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity)
    {
    }

    /**
     * @inheritDoc
     */
    public function revokeAccessToken($tokenId)
    {
    }

    /**
     * @inheritDoc
     */
    public function isAccessTokenRevoked($tokenId)
    {
        return false;
    }
}