<?php

namespace App\Common\Infrastructure\Delivery\Symfony\Serializer\Api;

use App\Common\Infrastructure\ServerConfiguration;
use App\Common\Application\Query\Dto\Dto;
use App\Shopsy\IdentityAccess\Main\Application\Dto\UserDto;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;

class JsonApiDtoNormalizer implements NormalizerInterface, ContextAwareNormalizerInterface, CacheableSupportsMethodInterface
{
    public const FORMAT = 'json';
    public const CONTEXT_FORMAT = 'jsonApi';
    public const TYPES = [
        UserDto::class => 'users'
    ];

    /**
     * @var ServerConfiguration
     */
    private $serverConfiguration;

    /**
     * @var ObjectNormalizer
     */
    private $objectNormalizer;

    /**
     * JsonApiDtoNormalizer Constructor
     *
     * @param ServerConfiguration $serverConfiguration
     * @param ObjectNormalizer $objectNormalizer
     */
    public function __construct(ServerConfiguration $serverConfiguration, ObjectNormalizer $objectNormalizer)
    {
        $this->serverConfiguration = $serverConfiguration;
        $this->objectNormalizer = $objectNormalizer;
    }

    /**
     * @inheritdoc
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $route = $context['request']->get('_route');
        $params = $context['request']->request->all() + $context['request']->query->all();

        $data = [
            'type' => self::TYPES[get_class($object)],
            'id' => $object->getId(),
            'attributes' => $this->objectNormalizer->normalize($object, $format, $context),
            'links' => [
                'self' => $this->serverConfiguration->generateUrl($route, array_merge($params, ['id' =>  $object->getId()]))
            ],
            'relationships' => []
        ];

        return $data;
    }

    /**
     * @inheritdoc
     */
    public function supportsNormalization($data, $format = null, $context = [])
    {
        return self::FORMAT === $format && $data instanceof Dto && !empty($context[self::CONTEXT_FORMAT]);
    }

    /**
     * @inheritdoc
     */
    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
