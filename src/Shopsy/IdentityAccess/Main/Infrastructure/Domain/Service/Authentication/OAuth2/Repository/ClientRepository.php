<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Domain\Service\Authentication\OAuth2\Repository;

use App\Shopsy\IdentityAccess\Main\Infrastructure\Domain\Authentication\OAuth2\Entity\Client;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;

class ClientRepository implements ClientRepositoryInterface
{
    const DEFAULT_CLIENT_NAME = 'Resource owner password credentials grant';
    const DEFAULT_CLIENT_ID = 'resource_owner_password_credentials_grant';
    const DEFAULT_CLIENT_SECRET = 'resource_owner_password_credentials_grant';

    /**
     * @inheritDoc
     */
    public function getClientEntity($clientIdentifier)
    {
        $client = new Client();

        $client->setIdentifier($clientIdentifier);
        $client->setName(self::DEFAULT_CLIENT_NAME);
        $client->setRedirectUri('');
        $client->setConfidential();

        return $client;
    }

    /**
     * @inheritDoc
     */
    public function validateClient($clientIdentifier, $clientSecret, $grantType)
    {
        $clients = [
            self::DEFAULT_CLIENT_ID => [
                'secret' => password_hash(self::DEFAULT_CLIENT_SECRET, PASSWORD_BCRYPT),
                'name' => self::DEFAULT_CLIENT_NAME,
                'redirect_uri' => '',
                'is_confidential' => true,
            ],
        ];

        if (array_key_exists($clientIdentifier, $clients) === false) {
            return false;
        }

        if ($clients[$clientIdentifier]['is_confidential'] === true && password_verify($clientSecret, $clients[$clientIdentifier]['secret']) === false) {
            return false;
        }

        return true;
    }
}