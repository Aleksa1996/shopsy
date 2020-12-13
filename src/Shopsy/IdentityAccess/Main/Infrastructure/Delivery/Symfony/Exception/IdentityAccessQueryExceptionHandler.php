<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\Exception;

use App\Common\Application\ExceptionHandler;
use App\Common\Application\Query\QueryException;
use App\Shopsy\IdentityAccess\Main\Application\Exception\Query\UserNotFoundQueryException;

class IdentityAccessQueryExceptionHandler implements ExceptionHandler
{
    /**
     * {@inheritDoc}
     */
    public function handle(\Exception $e)
    {
        if ($e instanceof UserNotFoundQueryException) {
            throw IdentityAccessHttpException::createFromQueryException($e, 404);
        }

        if ($e instanceof QueryException) {
            throw IdentityAccessHttpException::createFromQueryException($e);
        }

        throw $e;
    }
}
