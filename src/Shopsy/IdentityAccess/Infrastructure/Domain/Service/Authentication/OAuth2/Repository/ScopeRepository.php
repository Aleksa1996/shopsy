<?php


namespace App\Shopsy\IdentityAccess\Infrastructure\Domain\Service\Authentication\OAuth2\Repository;


use App\Shopsy\IdentityAccess\Infrastructure\Domain\Authentication\OAuth2\Entity\Scope;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;

class ScopeRepository implements ScopeRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getScopeEntityByIdentifier($identifier)
    {
        $scopes = [
            '*' => [
                'description' => 'All',
            ],
            'basic' => [
                'description' => 'Basic details about you',
            ],
            'email' => [
                'description' => 'Your email address',
            ],
        ];

        if (\array_key_exists($identifier, $scopes) === false) {
            return null;
        }

        $scope = new Scope();
        $scope->setIdentifier($identifier);

        return $scope;
    }

    /**
     * {@inheritdoc}
     */
    public function finalizeScopes(array $scopes, $grantType, ClientEntityInterface $clientEntity, $userIdentifier = null)
    {
        $filteredScopes = [];

        /** @var Scope $scope */
        foreach ($scopes as $scope) {
            $filteredScopes[] = $scope;
        }

        return $filteredScopes;
    }
}