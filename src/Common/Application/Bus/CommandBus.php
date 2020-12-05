<?php

namespace App\Common\Application\Bus;


use App\Common\Application\Command\CommandHandler;
use App\Common\Application\Command\TransactionalCommandHandler;
use App\Common\Application\Command\TransactionalSession;
use ReflectionException;
use ReflectionMethod;

class CommandBus
{
    /**
     * @var array
     */
    private $commandHandlers = [];

    /**
     * @var TransactionalSession
     */
    private $transactionalSession;


    public function __construct(TransactionalSession $transactionalSession)
    {
        $this->transactionalSession = $transactionalSession;
    }

    /**
     * @param $command
     *
     * @throws HandlerNotFoundException
     */
    public function handle($command)
    {
        $commandClass = get_class($command);

        if (!isset($this->commandHandlers[$commandClass])) {
            throw new HandlerNotFoundException($commandClass);
        }

        $commandHandler = $this->commandHandlers[$commandClass];

        $commandHandler->execute($command);
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

        $this->commandHandlers[$commandClass] = new TransactionalCommandHandler($commandHandler, $this->transactionalSession);
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