<?php

namespace App\Shopsy\IdentityAccess\Test\Infrastructure\Persistence\Doctrine\Access\DataFixtures;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Common\Infrastructure\ServerConfiguration;
use App\Common\Infrastructure\Service\Hasher\Hasher;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Access\Role;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Access\RolePermission;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Access\RoleRepository;

class RoleFixtures extends Fixture
{
    /**
     * @var RoleRepository
     */
    private $roleRepository;

    /**
     * RoleFixtures Constructor
     *
     * @param RoleRepository $roleRepository
     * @param Hasher $hasher
     * @param ServerConfiguration $serverConfiguration
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $role = new Role(
            $this->roleRepository->nextIdentity(),
            'User Role',
            'ROLE_USER',
            true
        );
        $role->addPermission(
            RolePermission::LIST_ACTION,
            User::class,
        );
        $manager->persist($role);

        $role = new Role(
            $this->roleRepository->nextIdentity(),
            'Admin Role',
            'ROLE_ADMIN',
            true
        );
        $role->addPermission(
            RolePermission::LIST_ACTION,
            User::class,
        );
        $manager->persist($role);

        $manager->flush();
    }
}
