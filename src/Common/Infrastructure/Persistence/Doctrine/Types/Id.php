<?php
namespace App\Common\Infrastructure\Persistence\Doctrine\Types;

use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Doctrine\UuidType;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\Common\Domain\Id as IdValueObject;

class Id extends UuidType
{
    /**
     * @var string
     */
    const name = 'uuid';

    /**
     * @var string
     */
    const className = IdValueObject::class;

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
