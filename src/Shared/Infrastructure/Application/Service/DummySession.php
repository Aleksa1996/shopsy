<?php


namespace App\Shared\Infrastructure\Application\Service;


use App\Shared\Application\Service\TransactionalSession;

class DummySession implements TransactionalSession
{

    /**
     * @inheritDoc
     */
    public function executeAtomically(callable $operation)
    {
        return call_user_func($operation);
    }
}