<?php

namespace App\Common\Domain\Validator\Specification;

class AnyOfSpecification extends Specification
{
    /**
     * @var Specification[]
     */
    private $specifications;

    /**
     * @param Specification ...$specifications
     */
    public function __construct(Specification ...$specifications)
    {
        $this->specifications = $specifications;
    }

    /**
     * {@inheritdoc}
     */
    public function isSatisfiedBy($object)
    {
        foreach ($this->specifications as $specification) {
            if (!$specification->isSatisfiedBy($object)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return Specification[]
     */
    public function specifications()
    {
        return $this->specifications;
    }
}
