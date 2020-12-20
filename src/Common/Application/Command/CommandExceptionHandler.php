<?php

namespace App\Common\Application\Command;

use App\Common\Application\Command\CommandException;
use App\Common\Application\ExceptionHandler;
use App\Common\Domain\DomainException;

class CommandExceptionHandler implements ExceptionHandler
{
    /**
     * @inheritDoc
     */
    public function handle(\Exception $e)
    {
        if ($e instanceof CommandException) {
            throw $e;
        }

        if ($e instanceof DomainException) {
            throw new CommandException('Domain Error', $e->getMessage(), [], $e->getMessage(), $e->getCode(), $e->getPrevious());
        }

        dd($e->getTraceAsString());

        throw new CommandException('Internal Error', 'Command failed to execute', [], $e->getMessage(), $e->getCode(), $e->getPrevious());
    }
}
