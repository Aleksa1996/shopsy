<?php

namespace App\Shopsy\IdentityAccess\Test\Infrastructure\Persistence\Doctrine\Identity\DataFixtures;

use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Common\Infrastructure\Service\Hasher\Hasher;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\User;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserActive;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserEmail;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserFullName;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserPassword;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserUsername;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserRepository;

class UserFixtures extends Fixture
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var Hasher
     */
    private $hasher;

    /**
     * UserFixtures Constructor
     *
     * @param Hasher $hasher
     */
    public function __construct(UserRepository $userRepository, Hasher $hasher)
    {
        $this->userRepository = $userRepository;
        $this->hasher = $hasher;
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 100; $i++) {
            $manager->persist(
                new User(
                    $this->userRepository->nextIdentity(),
                    new UserFullName($this->faker->name),
                    new UserUsername($this->faker->username),
                    new UserEmail($this->faker->email),
                    new UserPassword($this->hasher->hash('pass123')),
                    new UserActive(true)
                )
            );
        }

        $manager->persist(
            new User(
                $this->userRepository->nextIdentity(),
                new UserFullName('Administrator'),
                new UserUsername('admin'),
                new UserEmail('admin@shopsy.com'),
                new UserPassword($this->hasher->hash('admin123')),
                new UserActive(true)
            )
        );

        $manager->flush();
    }
}
