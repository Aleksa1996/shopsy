<?php

namespace App\Common\Application\Bus\Command\Middleware;

use App\Common\Application\Command\TransactionalSession;
use App\Common\Application\Bus\Command\Middleware;


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
