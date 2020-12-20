<?php


namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Domain\Service\Authentication\OAuth2\Repository;


use App\Shopsy\IdentityAccess\Main\Infrastructure\Domain\Service\Authentication\OAuth2\Entity\ScopeEntity;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;

class ScopeRepository implements ScopeRepositoryInterface
{
    public const SCOPES = [
        '*' => [
            'description' => 'All',
        ],
        'basic' => [
            'description' => 'Basic details',
        ],
        'email' => [
            'description' => 'Email address',
        ],
    ];

    /**
     * @inheritdoc
     */
    public function getScopeEntityByIdentifier($scopeIdentifier)
    {
        if (array_key_exists($scopeIdentifier, self::SCOPES) === false) {
            return null;
        }

        $scope = new ScopeEntity();
        $scope->setIdentifier($scopeIdentifier);

        return $scope;
    }

    /**
     * @inheritdoc
     */
    public function finalizeScopes(array $scopes, $grantType, ClientEntityInterface $clientEntity, $userIdentifier = null)
    {
        $filteredScopes = [];

        foreach ($scopes as $scope) {
            $filteredScopes[] = $scope;
        }

        return $filteredScopes;
    }
}
