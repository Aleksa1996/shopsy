<?php


namespace App\Shopsy\IdentityAccess\Infrastructure\Delivery\Api\Symfony\ParamConverter;


use App\Shopsy\IdentityAccess\Infrastructure\Delivery\Api\Symfony\Exception\RequestValidationException;
use ReflectionClass;
use ReflectionException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class JsonBodySerializableConverter implements ParamConverterInterface
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

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
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * @param Request $request
     * @param ParamConverter $configuration
     *
     * @return bool|void
     *
     * @throws ReflectionException
     * @throws RequestValidationException
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $reflection = new ReflectionClass($configuration->getClass());
        $obj = $reflection->newInstance();

        if (strpos($request->headers->get('Content-Type'), 'application/json') !== false) {
            $body = $request->getContent();
            try {
                $obj = $this->serializer->deserialize($body, $configuration->getClass(), 'json');
            } catch (NotEncodableValueException $e) {
                throw new BadRequestHttpException('json syntax error', $e);
            }
        }

        $this->handleRequestValidation($request, $obj);

        $request->attributes->set($configuration->getName(), $obj);
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

        return in_array(JsonBodySerializableInterface::class, class_implements($class));
    }

    /**
     * @param $request
     * @param $obj
     *
     * @throws RequestValidationException
     */
    private function handleRequestValidation($request, $obj)
    {
        $violationList = $this->validator->validate($obj);
        $request->attributes->set('_violations', $violationList);

        if ($violationList->count() >= 1) {
            throw new RequestValidationException($violationList);
        }
    }
}