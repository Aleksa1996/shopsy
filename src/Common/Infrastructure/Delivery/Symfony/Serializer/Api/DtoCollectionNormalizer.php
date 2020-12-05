<?php

namespace App\Common\Infrastructure\Delivery\Symfony\Serializer\Api;

use App\Common\Application\Dto\DtoCollection;
use App\Common\Infrastructure\ServerConfiguration;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;

class DtoCollectionNormalizer implements NormalizerInterface, ContextAwareNormalizerInterface, NormalizerAwareInterface, CacheableSupportsMethodInterface
{
    use NormalizerAwareTrait;

    public const FORMAT = 'json';
    public const CONTEXT_FORMAT = 'jsonApi';

    /**
     * @var ServerConfiguration
     */
    private $serverConfiguration;

    /**
     * DtoCollectionNormalizer Constructor
     *
     * @param RouterInterface $params
     */
    public function __construct(ServerConfiguration $serverConfiguration)
    {
        $this->serverConfiguration = $serverConfiguration;
    }

    /**
     * {@inheritdoc}
     *
     * @param DtoCollection $object
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [
            'meta' => $this->generateMeta($object, $context),
            'data' => empty($object->getData()) ? [] : $this->normalizer->normalize($object->getData(), $format, $context),
            'links' => $this->generateLinks($object, $context)
        ];

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null, $context = [])
    {
        return self::FORMAT === $format && $data instanceof DtoCollection && !empty($context[self::CONTEXT_FORMAT]);
    }

    /**
     * {@inheritdoc}
     */
    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }

    /**
     * @param DtoCollection $dtoCollection
     * @param array $context
     *
     * @return array
     */
    private function generateLinks($dtoCollection, $context)
    {
        return [
            'self' => $this->serverConfiguration->generateUrl($context['routeName'], ['page' =>  $dtoCollection->getPage()]),
            'first' => $this->serverConfiguration->generateUrl($context['routeName'], ['page' =>  $dtoCollection->getfirstPage()]),
            'next' => $this->serverConfiguration->generateUrl($context['routeName'], ['page' =>  $dtoCollection->getNextPage()]),
            'last' => $this->serverConfiguration->generateUrl($context['routeName'], ['page' =>  $dtoCollection->getLastPage()]),
        ];
    }

    /**
     * @param DtoCollection $dtoCollection
     * @param array $context
     *
     * @return array
     */
    private function generateMeta($dtoCollection, $context)
    {
        return [
            'totalPages' => $dtoCollection->getTotalPages(),
            'totalItems' => $dtoCollection->getTotalItems()
        ];
    }
}
