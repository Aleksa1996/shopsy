<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Domain\Service\Auth\OAuth2\Repository;

use App\Common\Domain\Id;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserId;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Auth\AccessToken;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use App\Shopsy\IdentityAccess\Main\Infrastructure\Domain\Service\Auth\OAuth2\Entity\AccessTokenEntity;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Auth\AccessTokenRepository as AppAccessTokenRepository;

class AccessTokenRepository implements AccessTokenRepositoryInterface
{
    /**
     * @var AppAccessTokenRepository
     */
    private $appAccessTokenRepository;

    /**
     * AccessTokenRepository Constructor
     *
     * @param AppAccessTokenRepository $userRepository
     */
    public function __construct(AppAccessTokenRepository $appAccessTokenRepository)
    {
        $this->appAccessTokenRepository = $appAccessTokenRepository;
    }

    /**
     * @inheritDoc
     */
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null)
    {
        $accessToken = new AccessTokenEntity();
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
        $appAccessToken = new AccessToken(
            $this->appAccessTokenRepository->nextIdentity(),
            $accessTokenEntity->getIdentifier(),
            new UserId($accessTokenEntity->getUserIdentifier()),
            new Id($accessTokenEntity->getClient()->getIdentifier()),
            $accessTokenEntity->getScopes(),
            false,
            $accessTokenEntity->getExpiryDateTime()
        );

        $this->appAccessTokenRepository->add($appAccessToken);
    }

    /**
     * @inheritDoc
     */
    public function revokeAccessToken($tokenId)
    {
        $appAccessToken = $this->appAccessTokenRepository->findByIdentifier($tokenId);

        if ($appAccessToken) {
            $appAccessToken->revoke();
        }
    }

    /**
     * @inheritDoc
     */
    public function isAccessTokenRevoked($tokenId)
    {
        $appAccessToken = $this->appAccessTokenRepository->findByIdentifier($tokenId);

        if (!$appAccessToken) {
            return true;
        }

        return $appAccessToken->getRevoked();
    }
}
