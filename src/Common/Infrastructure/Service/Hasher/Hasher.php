<?php

namespace App\Common\Infrastructure\Service\Hasher;


interface Hasher
{
    /**
     * @param string $value
     *
     * @return string
     */
    public function hash($value);

    /**
     * @param string $value
     * @param string $hash
     *
     * @return bool
     */
    public function verify($value, $hash);
}
