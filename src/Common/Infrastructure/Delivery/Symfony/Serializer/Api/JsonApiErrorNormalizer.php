<?php

namespace App\Common\Infrastructure\Delivery\Symfony\Serializer\Api;

use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use App\Common\Infrastructure\Delivery\Symfony\Exception\BaseHttpException;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;

class JsonApiErrorNormalizer implements NormalizerInterface, ContextAwareNormalizerInterface, NormalizerAwareInterface, CacheableSupportsMethodInterface
{
    use NormalizerAwareTrait;

    /**
     * @var ErrorNormalizer
     */
    private $jsonApiErrorNormalizer;

    /**
     * @inheritDoc
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        return [
            'errors' =>  $this->normalizer->normalize($context['exception']->getErrors(), $format, $context)
        ];
    }

    /**
     * @inheritDoc
     */
    public function supportsNormalization($data, string $format = null, $context = [])
    {
        return $data instanceof FlattenException &&
            !empty($context['exception']) &&
            is_object($context['exception']) &&
            $context['exception'] instanceof BaseHttpException;
    }

    /**
     * @inheritdoc
     */
    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
