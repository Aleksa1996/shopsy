<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Domain\Service\Authentication\OAuth2\Repository;

use App\Common\Domain\Id;
use App\Common\Infrastructure\Service\Hasher\Hasher;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use App\Shopsy\IdentityAccess\Main\Infrastructure\Domain\Service\Authentication\OAuth2\Entity\ClientEntity;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Auth\ClientRepository as AppClientRepository;

class ClientRepository implements ClientRepositoryInterface
{
    /**
     * @var AppClientRepository
     */
    private $appClientRepository;

    /**
     * @var Hasher
     */
    private $hasher;

    /**
     * ClientRepository Constructor
     *
     * @param AppClientRepository $appClientRepository
     * @param Hasher $hasher
     */
    public function __construct(AppClientRepository $appClientRepository, Hasher $hasher)
    {
        $this->appClientRepository = $appClientRepository;
        $this->hasher = $hasher;
    }

    /**
     * @inheritDoc
     */
    public function getClientEntity($clientIdentifier)
    {
        $appClient = $this->appClientRepository->findById(new Id($clientIdentifier));

        $client = new ClientEntity();
        $client->setIdentifier($appClient->getId());
        $client->setName($appClient->getName());
        $client->setRedirectUri($appClient->getRedirectUri());

        if ($appClient->getConfidential()) {
            $client->setConfidential();
        }

        return $client;
    }

    /**
     * @inheritDoc
     */
    public function validateClient($clientIdentifier, $clientSecret, $grantType)
    {
        $appClient = $this->appClientRepository->findById(new Id($clientIdentifier));

        if (!$appClient) {
            return false;
        }

        if ($appClient->getConfidential() === true && $this->hasher->verify($clientSecret, $appClient->getSecret())  === false) {
            return false;
        }

        return true;
    }
}
