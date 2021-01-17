<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\Exception;

use App\Common\Application\ExceptionHandler;
use App\Common\Application\Query\QueryException;
use App\Common\Infrastructure\Delivery\Symfony\ResponseDto\ErrorDto;
use App\Shopsy\IdentityAccess\Main\Application\Exception\Query\UnauthorizedQueryException;
use App\Shopsy\IdentityAccess\Main\Application\Exception\Query\ValidationErrorQueryException;
use App\Shopsy\IdentityAccess\Main\Application\Exception\Query\UserNotFoundQueryException;

class IdentityAccessQueryExceptionHandler implements ExceptionHandler
{
    /**
     * @inheritDoc
     */
    public function handle(\Exception $e)
    {
        if ($e instanceof UserNotFoundQueryException) {
            throw IdentityAccessHttpException::createFromQueryException($e, 404);
        }

        if ($e instanceof ValidationErrorQueryException) {
            throw IdentityAccessHttpException::createFromQueryException($e, 400);
        }

        if ($e instanceof UnauthorizedQueryException) {
            throw IdentityAccessHttpException::createFromQueryException($e, 401);
        }

        if ($e instanceof QueryException) {
            throw IdentityAccessHttpException::createFromQueryException($e);
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
