<?php

namespace App\Common\Application\Bus\Command;

use App\Common\Application\Command\TransactionalSession;


class TransactionalMiddleware implements Middleware
{
    /**
     * TransactionalMiddleware constructor.
     *
     * @param TransactionalSession $transactionalSession
     */
    public function __construct(TransactionalSession $transactionalSession)
    {
        $this->transactionalSession = $transactionalSession;
    }

    /**
     * @param object $command
     * @param callable $next
     *
     * @return void
     */
    public function execute(object $command, callable $next)
    {
        $operation = function () use ($command, $next) {
            return $next($command);
        };

        return $this->transactionalSession->executeAtomically($operation);
    }
}
