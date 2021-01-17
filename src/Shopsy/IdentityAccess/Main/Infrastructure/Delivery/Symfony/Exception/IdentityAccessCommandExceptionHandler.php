<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\Exception;

use App\Common\Application\ExceptionHandler;
use App\Common\Application\Command\CommandException;
use App\Common\Infrastructure\Delivery\Symfony\ResponseDto\ErrorDto;
use App\Shopsy\IdentityAccess\Main\Application\Exception\Command\UnauthorizedCommandException;
use App\Shopsy\IdentityAccess\Main\Application\Exception\Command\ValidationErrorCommandException;
use App\Shopsy\IdentityAccess\Main\Application\Exception\Command\UserAuthFailedCommandException;
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

        if ($e instanceof UserAuthFailedCommandException) {
            throw IdentityAccessHttpException::createFromCommandException($e, 400);
        }

        if ($e instanceof ValidationErrorCommandException) {
            throw IdentityAccessHttpException::createFromCommandException($e, 400);
        }

        if ($e instanceof UnauthorizedCommandException) {
            throw IdentityAccessHttpException::createFromCommandException($e, 401);
        }

        if ($e instanceof CommandException) {
            throw IdentityAccessHttpException::createFromCommandException($e);
        }

        throw new IdentityAccessHttpException(
            new ErrorDto('Internal Server Error', 'The backend responded with an error'),
            500,
            $e->getMessage(),
            $e->getCode(),
            [],
            $e->getPrevious()
        );
    }
}
