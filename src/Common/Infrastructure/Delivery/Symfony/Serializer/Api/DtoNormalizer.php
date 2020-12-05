<?php

namespace App\Common\Infrastructure\Delivery\Symfony\Serializer\Api;

use App\Common\Application\Dto\Dto;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;

class DtoNormalizer implements NormalizerInterface, ContextAwareNormalizerInterface, CacheableSupportsMethodInterface
{
    public const FORMAT = 'json';
    public const CONTEXT_FORMAT = 'jsonApi';

    /**
     * DtoNormalizer Constructor
     *
     * @param ObjectNormalizer $normalizer
     */
    public function __construct(ObjectNormalizer $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [
            'type' => 'type',
            'id' => $object->getId(),
            'attributes' => $this->normalizer->normalize($object, $format, $context)
        ];

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null, $context = [])
    {
        return self::FORMAT === $format && $data instanceof Dto && !empty($context[self::CONTEXT_FORMAT]);
    }

    /**
     * {@inheritdoc}
     */
    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
