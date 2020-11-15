<?php


namespace App\Shopsy\Users\Infrastructure\Persistence\Doctrine\Types;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use App\Shopsy\Users\Domain\Model\UserUsername as UserUsernameValueObject;

class UserUsername extends StringType
{
    /**
     * @var string
     */
    const name = 'user_username';

    /**
     * @var string
     */
    const className = UserUsernameValueObject::class;

    /**
     * @inheritDoc
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $className = self::className;

        return new $className($value);
    }

    /**
     * @inheritDoc
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->getUsername();
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return self::name;
    }
}