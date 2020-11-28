<?php

namespace App\Common\Infrastructure\Delivery\Symfony\Serializer\Api;

use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Common\Infrastructure\Delivery\Symfony\Exception\RequestValidationException;

class ErrorNormalizer implements NormalizerInterface
{
    /**
     * @var array
     */
    private static $supportsExceptions = [
        RequestValidationException::class
    ];

    /**
     * @inheritDoc
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        $data = [];
        $data['@context'] = '/contexts/Error';
        $data['@type'] = 'hydra:Error';
        $data['hydra:title'] = 'An error occurred';
        $data['hydra:description'] = $context['exception']->getMessage();

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof FlattenException && in_array($data->getClass(), self::$supportsExceptions);
    }
}
