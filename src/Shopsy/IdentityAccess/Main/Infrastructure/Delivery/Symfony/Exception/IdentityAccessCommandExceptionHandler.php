<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\Exception;

use App\Common\Application\Command\CommandException;
use App\Common\Application\ExceptionHandler;
use App\Shopsy\IdentityAccess\Main\Application\Exception\Command\UserNotFoundCommandException;

class IdentityAccessCommandExceptionHandler implements ExceptionHandler
{
    /**
     * @inheritDoc
     */
    public function handle(\Exception $e)
    {
        if ($e instanceof UserNotFoundCommandException) {
            throw IdentityAccessHttpException::createFromCommandException($e, 404);
        }

        if ($e instanceof CommandException) {
            throw IdentityAccessHttpException::createFromCommandException($e);
        }

        throw $e;
    }
}
