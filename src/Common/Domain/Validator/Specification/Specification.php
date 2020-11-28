<?php

namespace App\Common\Domain\Validator\Specification;

abstract class Specification
{
    /**
     * @param mixed $object
     * @return bool
     */
    abstract public function isSatisfiedBy($object);

    /**
     * @param Specification $specification
     * @return AndSpecification
     */
    public function and(Specification $specification)
    {
        return new AndSpecification($this, $specification);
    }

    /**
     * @param Specification $specification
     * @return OrSpecification
     */
    public function or(Specification $specification)
    {
        return new OrSpecification($this, $specification);
    }

    /**
     * @return NotSpecification
     */
    public function not()
    {
        return new NotSpecification($this);
    }
}
