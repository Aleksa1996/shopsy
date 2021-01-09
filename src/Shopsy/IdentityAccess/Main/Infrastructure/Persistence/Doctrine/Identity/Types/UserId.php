<?php


namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Persistence\Doctrine\Identity\Types;

use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Doctrine\UuidType;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserId as UserIdValueObject;

class UserId extends UuidType
{
    /**
     * @var string
     */
    const name = 'user_id';

    /**
     * @var string
     */
    const className = UserIdValueObject::class;

    /**
     * @inheritdoc
     *
     * @param string|UuidInterface|null $value
     * @param AbstractPlatform $platform
     *
     * @return UuidInterface|null
     *
     * @throws ConversionException
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
    public function getName()
    {
        return self::name;
    }
}
