<?php

namespace App\Common\Infrastructure\Delivery\Symfony\Serializer\Api;

use App\Common\Infrastructure\ServerConfiguration;
use App\Common\Infrastructure\Application\Query\Dto\Dto;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use App\Common\Infrastructure\Application\Query\Dto\DtoCollection;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;

class JsonApiNormalizer implements NormalizerInterface, ContextAwareNormalizerInterface, NormalizerAwareInterface, CacheableSupportsMethodInterface
{
    use NormalizerAwareTrait;

    public const FORMAT = 'json';
    public const CONTEXT_FORMAT = 'jsonApi';

    /**
     * @var ServerConfiguration
     */
    private $serverConfiguration;

    /**
     * @var JsonApiDtoNormalizer
     */
    private $jsonApiDtoNormalizer;

    /**
     * JsonApiNormalizer Constructor
     *
     * @param ServerConfiguration $serverConfiguration
     * @param JsonApiDtoNormalizer $jsonApiDtoNormalizer
     */
    public function __construct(ServerConfiguration $serverConfiguration, JsonApiDtoNormalizer $jsonApiDtoNormalizer)
    {
        $this->serverConfiguration = $serverConfiguration;
        $this->jsonApiDtoNormalizer = $jsonApiDtoNormalizer;
    }

    /**
     * {@inheritdoc}
     *
     * @param DtoCollection|Dto $dtoCollection
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [];
        if ($object instanceof Dto) {
            $data['data'] = $this->jsonApiDtoNormalizer->normalize($object, $format, $context);
        }

        if ($object instanceof DtoCollection) {
            $context['jsonApiNormalizer'] = true;
            $data['data'] = empty($object->getData()) ? [] : $this->normalizer->normalize($object->getData(), $format, $context);
            $data['meta'] = $this->generateMeta($object, $context);
            $data['links'] = $this->generateLinks($object, $context);
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null, $context = [])
    {
        return self::FORMAT === $format && ($data instanceof DtoCollection || ($data instanceof Dto && !isset($context['jsonApiNormalizer']))) && !empty($context[self::CONTEXT_FORMAT]);
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
        if ($dtoCollection->getPagination()) {
            return [
                'self' => $this->serverConfiguration->generateUrl($context['routeName'], ['page' =>  $dtoCollection->getPagination()->getPage()]),
                'first' => $this->serverConfiguration->generateUrl($context['routeName'], ['page' =>  $dtoCollection->getPagination()->getfirstPage()]),
                'last' => $this->serverConfiguration->generateUrl($context['routeName'], ['page' =>  $dtoCollection->getPagination()->getLastPage()]),
                'prev' => null,
                'next' => $this->serverConfiguration->generateUrl($context['routeName'], ['page' =>  $dtoCollection->getPagination()->getNextPage()]),
            ];
        }

        return null;
    }

    /**
     * @param DtoCollection $dtoCollection
     * @param array $context
     *
     * @return array
     */
    private function generateMeta($dtoCollection, $context)
    {
        $meta = $dtoCollection->getMeta() + $dtoCollection->getPaginationMeta();

        return empty($meta) ? null : $meta;
    }
}
