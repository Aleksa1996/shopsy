<?php

namespace App\Shopsy\IdentityAccess\Main\Infrastructure\Delivery\Symfony\Exception;

use App\Common\Application\Command\CommandException;
use App\Common\Application\Query\QueryException;
use App\Common\Infrastructure\Delivery\Symfony\ResponseDto\ErrorDto;
use App\Common\Infrastructure\Delivery\Symfony\Exception\BaseHttpException;

class IdentityAccessHttpException extends BaseHttpException
{
    /**
     * @param CommandException $e
     *
     * @return self
     */
    public static function createFromCommandException(CommandException $e, $statusCode = 500)
    {
        $errors = [];
        foreach ($e->getErrors() as $error) {
            $source = '';
            if (array_key_exists('propertyPath', $error) && array_key_exists('message', $error)) {
                $source = ['pointer' => sprintf('/data/attributes/%s', $error['propertyPath'])];
                $errors[] = new ErrorDto('Bad Request', $error['message'], $source);
            }
        }

        $errors[] = new ErrorDto($e->getUserFriendlyTitle(), $e->getUserFriendlyMessage());

        return new static($errors, $statusCode, $e->getUserFriendlyMessage(), $e->getCode(), [], $e);
    }

    /**
     * @param QueryException $e
     *
     * @return self
     */
    public static function createFromQueryException(QueryException $e, $statusCode = 500)
    {
        $errors = [];
        foreach ($e->getErrors() as $error) {
            $source = '';
            if (array_key_exists('propertyPath', $error) && array_key_exists('message', $error)) {
                $source = ['pointer' => sprintf('/data/attributes/%s', $error['propertyPath'])];
                $errors[] = new ErrorDto('Bad Request', $error['message'], $source);
            }
        }

        $errors[] = new ErrorDto($e->getUserFriendlyTitle(), $e->getUserFriendlyMessage());

        return new static($errors, $statusCode, $e->getUserFriendlyMessage(), $e->getCode(), [], $e);
    }
}
