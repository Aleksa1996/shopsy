<?php

namespace App\Common\Domain\Validator\Specification;

class NotSpecification extends Specification
{
    /**
     * @var Specification
     */
    private $specification;

    /**
     * @param Specification $specification
     */
    public function __construct(Specification $specification)
    {
        $this->specification = $specification;
    }

    /**
     * @param mixed $object
     * @return bool
     */
    public function isSatisfiedBy($object)
    {
        return !$this->specification->isSatisfiedBy($object);
    }

    /**
     * @return Specification
     */
    public function specification()
    {
        return $this->specification;
    }
}
