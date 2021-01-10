<?php

namespace App\Common\Domain\Validator\Specification;

class OneOfSpecification extends Specification
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
     * @inheritDoc
     */
    public function isSatisfiedBy($object)
    {
        foreach ($this->specifications as $specification) {
            if ($specification->isSatisfiedBy($object)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return Specification[]
     */
    public function specifications()
    {
        return $this->specifications;
    }
}
