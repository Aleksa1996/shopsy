<?php

namespace App\Common\Infrastructure\Delivery\Symfony\Serializer\Api;

use App\Common\Application\Dto\DtoCollection;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;

class DtoCollectionNormalizer implements NormalizerInterface, ContextAwareNormalizerInterface, NormalizerAwareInterface, CacheableSupportsMethodInterface
{
    use NormalizerAwareTrait;

    public const FORMAT = 'json';
    public const CONTEXT_FORMAT = 'jsonld';

    /**
     * {@inheritdoc}
     *
     * @param DtoCollection $object
     */
    public function normalize($object, $format = null, array $context = [])
    {
        if (isset($context[self::CONTEXT_FORMAT])) {
            unset($context[self::CONTEXT_FORMAT]);
        }
// TODO: REKURZIJA ZAJEBAVA ALI SVAKAKO TREBA POZVATI DtoNormalizer
        $data = [];
        $data['@context'] = '/contexts/User';
        $data['@id'] = '/users';
        $data['@type'] = 'hydra:Collection';
        $data['hydra:member'] = empty($object->getData()) ? [] : $this->normalizer->normalize($object->getData(), $format, $context);
        $data['hydra:totalItems'] = $object->getTotal();
        $data['hydra:view'] = $this->generateView($object, $context);
        $data['hydra:search'] = $this->generateSearch($object, $context);

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null, $context = [])
    {
        return self::FORMAT === $format && $data instanceof DtoCollection && isset($context[self::CONTEXT_FORMAT]);
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
    private function generateView($dtoCollection, $context)
    {
        $urlTemplate = $context['url'] . '?page=%s';

        return [
            '@id' => sprintf($urlTemplate, $dtoCollection->getPage()),
            '@type' => 'hydra:PartialCollectionView',
            'hydra:first' => sprintf($urlTemplate, $dtoCollection->getfirstPage()),
            'hydra:last' => sprintf($urlTemplate, $dtoCollection->getLastPage()),
            'hydra:next' => sprintf($urlTemplate, $dtoCollection->getNextPage()),
        ];
    }

    /**
     * @param DtoCollection $dtoCollection
     * @param array $context
     *
     * @return array
     */
    private function generateSearch($dtoCollection, $context)
    {
        return [
            '@type' => 'hydra:IriTemplate',
            'hydra:template' => '/users{?properties[],order[id],order[fullName],order[username],order[email],order[active]}',
            'hydra:variableRepresentation' => 'BasicRepresentation',
            'hydra:mapping' => [
                [
                    '@type' => 'IriTemplateMapping',
                    'variable' => 'properties[]',
                    'property' => null,
                    'required' => false
                ],
                [
                    '@type' => 'IriTemplateMapping',
                    'variable' => 'order[id]',
                    'property' => 'id',
                    'required' => false
                ],
                [
                    '@type' => 'IriTemplateMapping',
                    'variable' => 'order[fullName]',
                    'property' => 'fullName',
                    'required' => false
                ],
                [
                    '@type' => 'IriTemplateMapping',
                    'variable' => 'order[username]',
                    'property' => 'username',
                    'required' => false
                ],
                [
                    '@type' => 'IriTemplateMapping',
                    'variable' => 'order[email]',
                    'property' => 'email',
                    'required' => false
                ],
                [
                    '@type' => 'IriTemplateMapping',
                    'variable' => 'order[active]',
                    'property' => 'active',
                    'required' => false
                ],
            ]
        ];
    }
}
