<?php

namespace App\Shopsy\IdentityAccess\Test\Infrastructure\Persistence\Doctrine\Auth\DataFixtures;

use App\Common\Infrastructure\ServerConfiguration;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Auth\Client;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Shopsy\IdentityAccess\Main\Domain\Service\PasswordHasher;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Auth\ClientRepository;

class ClientFixtures extends Fixture
{
    /**
     * @var ClientRepository
     */
    private $clientRepository;

    /**
     * @var PasswordHasher
     */
    private $passwordHasher;

    /**
     * @var ServerConfiguration
     */
    private $serverConfiguration;

    /**
     * ClientFixtures Constructor
     *
     * @param ClientRepository $clientRepository
     * @param PasswordHasher $passwordHasher
     */
    public function __construct(ClientRepository $clientRepository, PasswordHasher $passwordHasher, ServerConfiguration $serverConfiguration)
    {
        $this->clientRepository = $clientRepository;
        $this->passwordHasher = $passwordHasher;
        $this->serverConfiguration = $serverConfiguration;
    }

    public function load(ObjectManager $manager)
    {
        $manager->persist(
            new Client(
                $this->clientRepository->nextIdentity(),
                'Resource owner password credentials grant used for general purpose authentication',
                $this->passwordHasher->hash($this->serverConfiguration->getAppSecret()),
                '',
                true,
                true,
                true
            )
        );

        $manager->flush();
    }
}
