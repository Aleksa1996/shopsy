<?php


namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Persistence\Doctrine\Identity\Types;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserPassword as UserPasswordValueObject;

class UserPassword extends StringType
{
    /**
     * @var string
     */
    const name = 'user_password';

    /**
     * @var string
     */
    const className = UserPasswordValueObject::class;

    /**
     * @inheritDoc
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null || $value === '') {
            return null;
        }

        $className = self::className;

        return new $className($value);
    }

    /**
     * @inheritDoc
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof UserPasswordValueObject) {
            return $value->getPassword();
        }

        return $value;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return self::name;
    }
}
