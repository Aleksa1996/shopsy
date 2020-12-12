<?php

namespace App\Common\Application\Bus\Command\Middleware;


use ReflectionMethod;
use ReflectionException;
use App\Common\Application\Bus\Command\Middleware;
use App\Common\Application\Command\CommandHandler;
use App\Common\Application\Bus\HandlerNotFoundException;

class HandlerMiddleware implements Middleware
{
    /**
     * @var array
     */
    private $commandHandlers = [];

    /**
     * @param object $command
     * @param callable $next
     *
     * @return void
     */
    public function execute(object $command, callable $next)
    {
        $commandClass = get_class($command);

        if (!isset($this->commandHandlers[$commandClass])) {
            throw new HandlerNotFoundException($commandClass);
        }

        $commandHandler = $this->commandHandlers[$commandClass];

        return $commandHandler->execute($command);
    }

    /**
     * @param CommandHandler $commandHandler
     *
     * @throws ReflectionException
     * @throws CommandNotFoundException
     */
    public function register(CommandHandler $commandHandler)
    {
        $commandClass = $this->getCommandType($commandHandler);

        if (is_null($commandClass)) {
            throw new CommandNotFoundException($commandClass);
        }

        $this->commandHandlers[$commandClass] = $commandHandler;
    }

    /**
     * @param CommandHandler $commandHandler
     *
     * @return string
     *
     * @throws ReflectionException
     */
    private function getCommandType(CommandHandler $commandHandler)
    {
        $reflectionMethod = new ReflectionMethod(get_class($commandHandler), 'execute');
        $commandParameter = $reflectionMethod->getParameters()[0] ?? null;

        if (is_null($commandParameter)) {
            return $commandHandler;
        }

        return $commandParameter->getClass()->getName();
    }
}
