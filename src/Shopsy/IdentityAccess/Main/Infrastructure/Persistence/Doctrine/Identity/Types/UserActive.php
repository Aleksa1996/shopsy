<?php


namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Persistence\Doctrine\Identity\Types;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Identity\UserActive as UserActiveValueObject;
use Doctrine\DBAL\Types\BooleanType;

class UserActive extends BooleanType
{
    /**
     * @var string
     */
    const NAME = 'user_active';

    /**
     * @var string
     */
    const CLASS_NAME = UserActiveValueObject::class;

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
        if ($value instanceof UserActiveValueObject) {
            return $value->getActive();
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
