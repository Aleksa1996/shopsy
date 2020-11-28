<?php

namespace App\Common\Infrastructure\Delivery\Symfony\Serializer\Api;

use App\Common\Application\Dto\Dto;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;

class DtoNormalizer implements NormalizerInterface, ContextAwareNormalizerInterface, NormalizerAwareInterface, CacheableSupportsMethodInterface
{
    use NormalizerAwareTrait;

    public const FORMAT = 'json';
    public const CONTEXT_FORMAT = 'jsonld';

    /**
     * {@inheritdoc}
     *
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = $this->normalizer->normalize($object, $format, $context);
        $data['@context'] = '/contexts/User';
        $data['@id'] = sprintf('/users/%s', $object->getId());
        $data['@type'] = 'hydra:Resource';

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null, $context = [])
    {
        return self::FORMAT === $format && $data instanceof Dto && isset($context[self::CONTEXT_FORMAT]);
    }

    /**
     * {@inheritdoc}
     */
    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
