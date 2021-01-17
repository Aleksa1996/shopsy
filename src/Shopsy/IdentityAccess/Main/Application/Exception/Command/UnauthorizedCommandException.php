<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Exception\Command;


use Throwable;
use App\Common\Application\Command\CommandException;

class UnauthorizedCommandException extends CommandException
{
    /**
     * UnauthorizedCommandException Constructor
     *
     * @param string $userFriendlyTitle
     * @param string $userFriendlyMessage
     * @param array $errors
     * @param string $message
     * @param integer $code
     * @param Throwable $previous
     */
    public function __construct($userFriendlyTitle = 'Unauthorized', $userFriendlyMessage = 'You dont have permissions to do this action', $errors = [], $message = 'Unauthorized', $code = 0, Throwable $previous = null)
    {
        parent::__construct($userFriendlyTitle, $userFriendlyMessage, $errors, $message, $code, $previous);
    }
}
