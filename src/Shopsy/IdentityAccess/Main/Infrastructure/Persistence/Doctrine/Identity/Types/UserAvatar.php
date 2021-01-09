<?php


namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Persistence\Doctrine\Identity\Types;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserAvatar as UserAvatarValueObject;

class UserAvatar extends StringType
{
    /**
     * @var string
     */
    const NAME = 'user_avatar';

    /**
     * @var string
     */
    const CLASS_NAME = UserAvatarValueObject::class;

    /**
     * @inheritDoc
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null || $value === '') {
            return null;
        }

        $className = static::CLASS_NAME;

        return new $className($value);
    }

    /**
     * @inheritDoc
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof UserAvatarValueObject) {
            return $value->getAvatar();
        }

        return $value;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return static::NAME;
    }
}
