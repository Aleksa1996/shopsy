<?php

namespace App\Common\Infrastructure\Delivery\Symfony\Serializer\Api;

use App\Common\Application\Query\Dto\Dto;
use App\Common\Infrastructure\ServerConfiguration;
use App\Shopsy\IdentityAccess\Main\Application\Dto\RoleDto;
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
        UserDto::class => 'users',
        RoleDto::class => 'roles'
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
     * @inheritDoc
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $route = $context['request']->get('_route');
        $params = $context['request']->request->all() + $context['request']->query->all() + $context['request']->attributes->get('_route_params');

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
     * @inheritDoc
     */
    public function supportsNormalization($data, $format = null, $context = [])
    {
        return self::FORMAT === $format && $data instanceof Dto && !empty($context[self::CONTEXT_FORMAT]);
    }

    /**
     * @inheritDoc
     */
    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
