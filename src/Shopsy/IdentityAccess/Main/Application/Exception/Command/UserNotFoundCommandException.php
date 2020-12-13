<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Exception\Command;

use Throwable;
use App\Common\Application\Command\CommandException;

class UserNotFoundCommandException extends CommandException
{
    /**
     * UserNotFoundCommandException Constructor
     *
     * @param string $userFriendlyTitle
     * @param string $userFriendlyMessage
     * @param array $errors
     * @param string $message
     * @param integer $code
     * @param Throwable $previous
     */
    public function __construct($userFriendlyTitle = 'User not found', $userFriendlyMessage = 'User could not be found by provided criteria', $errors = [], $message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct($userFriendlyTitle, $userFriendlyMessage, $errors, $message, $code, $previous);
    }
}
