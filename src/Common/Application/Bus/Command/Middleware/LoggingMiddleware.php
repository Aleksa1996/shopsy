<?php

namespace App\Common\Application\Bus\Command\Middleware;

use Psr\Log\LoggerInterface;
use App\Common\Application\Bus\Command\Middleware;


class LoggingMiddleware implements Middleware
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * LoggingMiddleware constructor.
     *
     * @param LoggerInterface  $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param object $command
     * @param callable $next
     *
     * @return void
     */
    public function execute(object $command, callable $next)
    {
        $this->logger->info(sprintf('Command started: %s', get_class($command)));
        $result = $next($command);
        $this->logger->info(sprintf('Command ended: %s', get_class($command)));

        return $result;
    }
}
