<?php

namespace App\Common\Application\Bus\Command\Middleware;

use App\Common\Application\ExceptionHandler;
use App\Common\Application\Bus\Command\Middleware;


class ExceptionHandlingMiddleware implements Middleware
{
    /**
     * @var ExceptionHandler
     */
    private $exceptionHandler;

    /**
     * ExceptionHandlingMiddleware constructor.
     *
     * @param ExceptionHandler  $exceptionHandler
     */
    public function __construct(ExceptionHandler $exceptionHandler)
    {
        $this->exceptionHandler = $exceptionHandler;
    }

    /**
     * @param object $command
     * @param callable $next
     *
     * @return void
     */
    public function execute(object $command, callable $next)
    {
        try {
            return $next($command);
        } catch (\Exception $e) {
            $this->exceptionHandler->handle($e);
        }
    }
}
