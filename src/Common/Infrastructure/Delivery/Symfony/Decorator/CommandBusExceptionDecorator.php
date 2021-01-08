<?php

namespace App\Common\Infrastructure\Delivery\Symfony\Decorator;

use App\Common\Application\Bus\Bus;
use App\Common\Application\ExceptionHandler;
use App\Common\Application\Bus\Command\CommandBus;

class CommandBusExceptionDecorator implements Bus
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var ExceptionHandler
     */
    private $exceptionHandler;

    /**
     * CommandBusExceptionDecorator Constructor
     *
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus, ExceptionHandler $exceptionHandler)
    {
        $this->commandBus = $commandBus;
        $this->exceptionHandler = $exceptionHandler;
    }

    /**
     * @inheritDoc
     */
    public function handle($command)
    {
        try {
            return $this->commandBus->handle($command);
        } catch (\Exception $e) {
            $this->exceptionHandler->handle($e);
        }
    }
}
