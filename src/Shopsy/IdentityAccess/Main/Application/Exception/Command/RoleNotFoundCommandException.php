<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Exception\Command;


use Throwable;
use App\Common\Application\Command\CommandException;

class RoleNotFoundCommandException extends CommandException
{
    /**
     * RoleNotFoundCommandException Constructor
     *
     * @param string $userFriendlyTitle
     * @param string $userFriendlyMessage
     * @param array $errors
     * @param string $message
     * @param integer $code
     * @param Throwable $previous
     */
    public function __construct($userFriendlyTitle = 'Role not found', $userFriendlyMessage = 'You dont have permissions to do this action', $errors = [], $message = 'Role not found', $code = 0, Throwable $previous = null)
    {
        parent::__construct($userFriendlyTitle, $userFriendlyMessage, $errors, $message, $code, $previous);
    }
}
