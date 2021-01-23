<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Exception\Query;


use Throwable;
use App\Common\Application\Query\QueryException;

class RoleNotFoundQueryException extends QueryException
{
    /**
     * RoleNotFoundQueryException Constructor
     *
     * @param string $userFriendlyTitle
     * @param string $userFriendlyMessage
     * @param array $errors
     * @param string $message
     * @param integer $code
     * @param Throwable $previous
     */
    public function __construct($userFriendlyTitle = 'Role not found', $userFriendlyMessage = 'Role could not be found by provided criteria', $errors = [], $message = 'Role could not be found by provided criteria', $code = 0, Throwable $previous = null)
    {
        parent::__construct($userFriendlyTitle, $userFriendlyMessage, $errors, $message, $code, $previous);
    }
}
