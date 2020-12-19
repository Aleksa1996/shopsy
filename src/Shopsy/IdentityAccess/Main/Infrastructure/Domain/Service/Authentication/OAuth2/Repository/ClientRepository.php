<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Domain\Service\Authentication\OAuth2\Repository;

use App\Common\Domain\Id;
use App\Shopsy\IdentityAccess\Main\Domain\Service\PasswordHasher;
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
     * @var PasswordHasher
     */
    private $passwordHasher;

    /**
     * ClientRepository Constructor
     *
     * @param AppClientRepository $appClientRepository
     * @param PasswordHasher $passwordHasher
     */
    public function __construct(AppClientRepository $appClientRepository, PasswordHasher $passwordHasher)
    {
        $this->appClientRepository = $appClientRepository;
        $this->passwordHasher = $passwordHasher;
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

        if ($appClient->getConfidential() === true && $this->passwordHasher->verify($clientSecret, $appClient->getSecret())  === false) {
            return false;
        }

        return true;
    }
}
