<?php


namespace App\Shopsy\IdentityAccess\Main\Domain\Service;


interface Hasher
{
    /**
     * @param $password
     *
     * @return string
     */
    public function hash($password);

    /**
     * @param $password
     * @param $hash
     *
     * @return bool
     */
    public function verify($password, $hash);
}