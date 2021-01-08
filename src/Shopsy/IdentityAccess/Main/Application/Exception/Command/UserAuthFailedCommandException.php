<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Exception\Command;

use App\Common\Application\Command\CommandException;
use Throwable;

class UserAuthFailedCommandException extends CommandException
{
    /**
     * UserAuthFailedCommandException Constructor
     *
     * @param string $userFriendlyTitle
     * @param string $userFriendlyMessage
     * @param array $errors
     * @param string $message
     * @param integer $code
     * @param Throwable $previous
     */
    public function __construct($userFriendlyTitle = 'User auth failed', $userFriendlyMessage = 'User auth failed', $errors = [], $message = 'User auth failed', $code = 0, Throwable $previous = null)
    {
        parent::__construct($userFriendlyTitle, $userFriendlyMessage, $errors, $message, $code, $previous);
    }
}
