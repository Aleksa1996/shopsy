<?php

namespace App\Shared\Application\DataTransformer;

interface DataTransformer
{
    /**
     * @param mixed $object
     */
    public function write($object);

    /**
     * @return mixed $object
     */
    public function read();
}
