<?php

namespace App\Shopsy\IdentityAccess\Test\Infrastructure\Persistence\Doctrine\Auth\DataFixtures;

use App\Common\Infrastructure\ServerConfiguration;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Auth\Client;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Common\Infrastructure\Service\Hasher\Hasher;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Auth\ClientRepository;

class ClientFixtures extends Fixture
{
    /**
     * @var ClientRepository
     */
    private $clientRepository;

    /**
     * @var Hasher
     */
    private $hasher;

    /**
     * @var ServerConfiguration
     */
    private $serverConfiguration;

    /**
     * ClientFixtures Constructor
     *
     * @param ClientRepository $clientRepository
     * @param Hasher $hasher
     */
    public function __construct(ClientRepository $clientRepository, Hasher $hasher, ServerConfiguration $serverConfiguration)
    {
        $this->clientRepository = $clientRepository;
        $this->hasher = $hasher;
        $this->serverConfiguration = $serverConfiguration;
    }

    public function load(ObjectManager $manager)
    {
        $manager->persist(
            new Client(
                $this->clientRepository->nextIdentity(),
                'Resource owner password credentials grant used for general purpose authentication',
                $this->hasher->hash($this->serverConfiguration->getAppSecret()),
                '',
                true,
                true,
                true
            )
        );

        $manager->flush();
    }
}
