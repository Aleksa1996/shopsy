<?php

namespace App\Shopsy\IdentityAccess\Test\Infrastructure\Persistence\Doctrine\Identity\PHPUnit;

use PHPUnit\Framework\TestCase;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\User;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserId;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserEmail;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserActive;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserFullName;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserPassword;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserUsername;

class UserTest extends TestCase
{
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
            new UserPassword('hella'),
            new UserActive(true),
            null
        );

        $this->assertEquals('Aleksa Jovanovic', $user->getFullName()->getFullName());
    }
}
