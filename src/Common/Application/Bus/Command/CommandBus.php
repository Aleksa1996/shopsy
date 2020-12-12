<?php

namespace App\Common\Application\Bus\Command;


use App\Common\Application\Bus\HandlerNotFoundException;

class CommandBus
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
        $this->middlewareChain = $this->createExecutionChain(iterator_to_array($middlewares));
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
        $lastCallable = static fn () => null;

        while ($middleware = array_pop($middlewareList)) {
            $lastCallable = static fn (object $command) => $middleware->execute($command, $lastCallable);
        }

        return $lastCallable;
    }
}
