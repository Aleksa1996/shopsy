<?php


namespace App\Shopsy\Users\Infrastructure\Persistence\Doctrine\Types;

use Ramsey\Uuid\Doctrine\UuidType;

class UserId extends UuidType
{
    /**
     * @var string
     */
    const name = 'user_id';

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return self::name;
    }
}