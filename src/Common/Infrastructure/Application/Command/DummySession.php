<?php


namespace App\Common\Infrastructure\Application\Command;


use App\Common\Application\Command\TransactionalSession;

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