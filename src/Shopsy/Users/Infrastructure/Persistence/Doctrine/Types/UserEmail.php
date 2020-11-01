<?php


namespace App\Shopsy\Users\Infrastructure\Persistence\Doctrine\Types;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use App\Shopsy\Users\Domain\Model\UserEmail as UserEmailValueObject;

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
        return $value->getEmail();
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return self::name;
    }
}