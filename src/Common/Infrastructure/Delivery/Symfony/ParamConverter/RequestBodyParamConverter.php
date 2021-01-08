<?php

namespace App\Common\Infrastructure\Delivery\Symfony\ParamConverter;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Common\Infrastructure\Delivery\Symfony\RequestDto\RequestDto;
use App\Common\Infrastructure\Delivery\Symfony\Exception\BaseHttpException;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;

class RequestBodyParamConverter implements ParamConverterInterface
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var array
     */
    private $context = [];

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        if (!empty($groups)) {
            $this->context['groups'] = (array) $groups;
        }

        if (!empty($version)) {
            $this->context['version'] = $version;
        }

        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * @param Request $request
     * @param ParamConverter $configuration
     *
     * @return bool|void
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $options = (array) $configuration->getOptions();

        $context = [];
        if (isset($options['deserializationContext']) && is_array($options['deserializationContext'])) {
            $context = array_merge($this->context, $options['deserializationContext']);
        } else {
            $context = $this->context;
        }

        $format = $request->getContentType();
        $data = $request->getContent();

        if ($format === null && empty($data) && $request->request->count() > 0) {
            $format = 'json';
            $data = json_encode($request->request->all());
        }

        if ($format === null) {
            // TODO: Convert to BaseHttpException
            return $this->throwException(new UnsupportedMediaTypeHttpException(), $configuration);
        }

        try {
            $object = $this->serializer->deserialize(
                $data,
                $configuration->getClass(),
                $format,
                $context
            );
        } catch (ExceptionInterface $e) {
            // TODO: Convert to BaseHttpException
            return $this->throwException(new BadRequestHttpException($e->getMessage(), $e), $configuration);
        }

        $request->attributes->set($configuration->getName(), $object);

        if (null !== $this->validator && (!isset($options['validate']) || $options['validate'])) {
            $validatorOptions = $this->getValidatorOptions($options);
            $constraintViolationList  = $this->validator->validate($object, null, $validatorOptions['groups']);

            $request->attributes->set(
                '_violations',
                $constraintViolationList
            );

            if ($constraintViolationList->count() >= 1) {
                throw BaseHttpException::createFromConstraintViolationList($constraintViolationList);
            }
        }

        return true;
    }

    /**
     * @param ParamConverter $configuration
     *
     * @return bool
     */
    public function supports(ParamConverter $configuration)
    {
        $class = $configuration->getClass();

        if (!is_string($class)) {
            return false;
        }

        return in_array(RequestDto::class, class_implements($class));
    }

    /**
     * @param \Exception $exception
     * @param ParamConverter $configuration
     *
     * @return boolean
     */
    private function throwException(\Exception $exception, ParamConverter $configuration)
    {
        if ($configuration->isOptional()) {
            return false;
        }

        throw $exception;
    }

    /**
     * @param array $options
     *
     * @return array
     */
    private function getValidatorOptions(array $options): array
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'groups' => null,
            'traverse' => false,
            'deep' => false,
        ]);

        return $resolver->resolve(isset($options['validator']) ? $options['validator'] : []);
    }
}
