<?php


namespace App\Shared\Application\Service;


interface TransactionalSession
{
    /**
     * @param callable $operation
     *
     * @return mixed
     */
    public function executeAtomically(callable $operation);
}