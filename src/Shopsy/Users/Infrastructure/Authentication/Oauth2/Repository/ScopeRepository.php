<?php


namespace App\Shopsy\Users\Infrastructure\Authentication\Oauth2\Repository;


use App\Shopsy\Users\Infrastructure\Authentication\Oauth2\Entity\Scope;
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