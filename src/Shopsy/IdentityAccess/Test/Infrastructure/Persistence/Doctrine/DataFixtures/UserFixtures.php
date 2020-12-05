<?php

namespace App\Shopsy\IdentityAccess\Test\Infrastructure\Persistence\Doctrine\DataFixtures;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Shopsy\IdentityAccess\Main\Domain\Model\User\User;
use App\Shopsy\IdentityAccess\Main\Domain\Model\User\UserEmail;
use App\Shopsy\IdentityAccess\Main\Domain\Model\User\UserFullName;
use App\Shopsy\IdentityAccess\Main\Domain\Model\User\UserPassword;
use App\Shopsy\IdentityAccess\Main\Domain\Model\User\UserRepository;
use App\Shopsy\IdentityAccess\Main\Domain\Model\User\UserUsername;
use App\Shopsy\IdentityAccess\Main\Domain\Service\PasswordHasher;
use App\Shopsy\IdentityAccess\Main\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;

class UserFixtures extends Fixture
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var PasswordHasher
     */
    private $passwordHasher;

    /**
     * UserFixtures Constructor
     *
     * @param PasswordHasher $passwordHasher
     */
    public function __construct(UserRepository $userRepository, PasswordHasher $passwordHasher)
    {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 100; $i++) {
            $manager->persist(
                new User(
                    $this->userRepository->nextIdentity(),
                    new UserFullName(sprintf('Aleksa Jovanovic - %s', $i)),
                    new UserUsername(sprintf('aleksa.jovanovic.%s', $i)),
                    new UserEmail(sprintf('aleksa.jovanovic.%s@gmail.com', $i)),
                    new UserPassword($this->passwordHasher->hash(sprintf('aleksa.jovanovic.%s', $i)))
                )
            );
        }

        $manager->flush();
    }
}
