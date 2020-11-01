<?php

namespace App\Shared\Application\DataTransformer;

class NoTransformationDataTransformer implements DataTransformer
{
    /**
     * @var mixed
     */
    private $object;

    /**
     * @param mixed $object
     */
    public function write($object)
    {
        $this->object = $object;
    }

    /**
     * @return mixed $object
     */
    public function read()
    {
        return $this->object;
    }
}
