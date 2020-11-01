<?php


namespace App\Shopsy\Users\Infrastructure\Persistence\Doctrine\Types;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use App\Shopsy\Users\Domain\Model\UserFirstName as UserFirstNameValueObject;

class UserFirstName extends StringType
{
    /**
     * @var string
     */
    const name = 'user_first_name';

    /**
     * @var string
     */
    const className = UserFirstNameValueObject::class;

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
        return $value->getFirstName();
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return self::name;
    }
}