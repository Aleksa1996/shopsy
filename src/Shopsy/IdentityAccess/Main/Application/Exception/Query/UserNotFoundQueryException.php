<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Exception\Query;


use Throwable;
use App\Common\Application\Query\QueryException;

class UserNotFoundQueryException extends QueryException
{
    /**
     * UserNotFoundQueryException Constructor
     *
     * @param string $userFriendlyTitle
     * @param string $userFriendlyMessage
     * @param array $errors
     * @param string $message
     * @param integer $code
     * @param Throwable $previous
     */
    public function __construct($userFriendlyTitle = 'User not found', $userFriendlyMessage = 'User could not be found by provided criteria', $errors = [], $message = 'User could not be found by provided criteria', $code = 0, Throwable $previous = null)
    {
        parent::__construct($userFriendlyTitle, $userFriendlyMessage, $errors, $message, $code, $previous);
    }
}
