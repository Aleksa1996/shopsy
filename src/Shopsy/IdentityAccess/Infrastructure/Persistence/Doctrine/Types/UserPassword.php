<?php


namespace App\Shopsy\IdentityAccess\Infrastructure\Persistence\Doctrine\Types;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use App\Shopsy\IdentityAccess\Domain\Model\UserPassword as UserPasswordValueObject;

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
        $className = self::className;

        return new $className($value);
    }

    /**
     * @inheritDoc
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->getPassword();
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return self::name;
    }
}