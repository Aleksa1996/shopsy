<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Persistence\Doctrine\Access\Types;

use App\Common\Domain\Id;
use Doctrine\DBAL\Types\JsonType;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\Shopsy\IdentityAccess\Main\Domain\Model\Access\RolePermission as RolePermissionValueObject;

class RolePermissions extends JsonType
{
    /**
     * @var string
     */
    const NAME = 'permissions';

    /**
     * @var string
     */
    const CLASS_NAME = RolePermissionValueObject::class;

    /**
     * @inheritDoc
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $decoded = json_decode($value, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
            throw ConversionException::conversionFailed($value, static::NAME);
        }

        $className = static::CLASS_NAME;
        $value = [];

        foreach ($decoded as $object) {
            $value[] = new $className(
                new Id($object['id']),
                $object['action'],
                $object['resource']
            );
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        if (!is_array($value)) {
            throw ConversionException::conversionFailed($value, static::NAME);
        }

        $encoded = json_encode(array_values($value));

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw ConversionException::conversionFailedSerialization($value, static::NAME, json_last_error_msg());
        }

        return $encoded;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return static::NAME;
    }
}
