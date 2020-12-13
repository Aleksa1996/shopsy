<?php

namespace App\Common\Application\Bus\Command;

use App\Common\Application\Bus\Bus;
use App\Common\Application\Bus\HandlerNotFoundException;

class CommandBus implements Bus
{
    /**
     * @var Middleware
     */
    private $middlewareChain;

    /**
     * @param Middleware $middleware
     */
    public function __construct($middlewares)
    {
        $this->middlewareChain = $this->createExecutionChain($middlewares);
    }

    /**
     * @param $command
     *
     * @throws HandlerNotFoundException
     */
    public function handle($command)
    {
        return ($this->middlewareChain)($command);
    }

    /**
     * @param Middleware[] $middlewareList
     */
    private function createExecutionChain($middlewareList)
    {
        if (is_object($middlewareList) && ($middlewareList instanceof \Traversable)) {
            $middlewareList = iterator_to_array($middlewareList);
        }

        $lastCallable = static fn () => null;

        while ($middleware = array_pop($middlewareList)) {
            $lastCallable = static fn (object $command) => $middleware->execute($command, $lastCallable);
        }

        return $lastCallable;
    }
}
