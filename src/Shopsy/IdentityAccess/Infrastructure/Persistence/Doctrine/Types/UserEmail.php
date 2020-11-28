<?php


namespace App\Shopsy\IdentityAccess\Infrastructure\Persistence\Doctrine\Types;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use App\Shopsy\IdentityAccess\Domain\Model\User\UserEmail as UserEmailValueObject;

class UserEmail extends StringType
{
    /**
     * @var string
     */
    const name = 'user_email';

    /**
     * @var string
     */
    const className = UserEmailValueObject::class;

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
        if ($value instanceof UserEmailValueObject) {
            return $value->getEmail();
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