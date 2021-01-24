<?php

namespace App\Shopsy\IdentityAccess\Test\Domain\Model\Identity\PHPUnit;

use App\Common\Domain\Id;
use PHPUnit\Framework\TestCase;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Access\Role;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\User;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserId;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserEmail;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserActive;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserFullName;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserPassword;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserUsername;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    /**
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        //start the symfony kernel
        $kernel = static::createKernel();
        $kernel->boot();

        //get the DI container
        self::$container = $kernel->getContainer();
    }

    /**
     * @return void
     */
    public function testCreate()
    {
        $user = new User(
            new UserId(),
            new UserFullName('Aleksa Jovanovic'),
            new UserUsername('aleksa'),
            new UserEmail('aleksa@gmail.com'),
            new UserPassword('pass123'),
            new UserActive(true),
            null
        );

        $this->assertEquals('Aleksa Jovanovic', $user->getFullName()->getFullName());
        $this->assertEquals('pass123', $user->getPassword()->getPassword());
    }

    /**
     * @return void
     */
    public function testUpdate()
    {
        $user = new User(
            new UserId(),
            new UserFullName('Aleksa Jovanovic'),
            new UserUsername('aleksa'),
            new UserEmail('aleksa@gmail.com'),
            new UserPassword('pass123'),
            new UserActive(true),
            null
        );

        $active = false;
        $email = 'aleksaa@gmail.com';

        $user->setActive(new UserActive($active));
        $user->setEmail(new UserEmail($email));

        $this->assertEquals($active, $user->getActive()->getActive());
        $this->assertEquals($email, $user->getEmail()->getEmail());
    }

    /**
     * @return void
     */
    public function testRoles()
    {
        $user = new User(
            new UserId(),
            new UserFullName('Aleksa Jovanovic'),
            new UserUsername('aleksa'),
            new UserEmail('aleksa@gmail.com'),
            new UserPassword('pass123'),
            new UserActive(true),
            null
        );

        $role1 = new Role(new Id(), 'User Role', 'ROLE_USER', true);

        $user->attachRole($role1);
        $user->attachRole($role1);

        $this->assertCount(1, $user->getRoles());

        $user->detachRole($role1);

        $this->assertCount(0, $user->getRoles());

        $role2 = new Role(new Id(), 'Admin Role', 'ROLE_ADMIN', true);

        $user->attachRole($role1);
        $user->attachRole($role1);
        $user->attachRole($role2);
        $user->attachRole($role2);

        $this->assertIsArray($user->getRoles());

        $this->assertCount(2, $user->getRoles());
        $this->assertTrue($user->hasRole($role2));
        $this->assertTrue($user->hasRoleIdentifier($role1->getIdentifier()));

        $user->detachAllRoles();

        $this->assertCount(0, $user->getRoles());
        $this->assertFalse($user->hasRole($role1));
        $this->assertFalse($user->hasRoleIdentifier($role1->getIdentifier()));

        $user->setRoles([$role1]);

        $this->assertCount(1, $user->getRoles());
        $this->assertContainsOnlyInstancesOf(Role::class, $user->getRoles());
    }
}
