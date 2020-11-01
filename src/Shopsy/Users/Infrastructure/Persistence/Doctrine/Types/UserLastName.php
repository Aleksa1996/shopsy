<?php


namespace App\Shopsy\Users\Infrastructure\Persistence\Doctrine\Types;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use App\Shopsy\Users\Domain\Model\UserLastName as UserLastNameValueObject;

class UserLastName extends StringType
{
    /**
     * @var string
     */
    const name = 'user_last_name';

    /**
     * @var string
     */
    const className = UserLastNameValueObject::class;

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
        return $value->getLastName();
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return self::name;
    }
}