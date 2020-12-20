<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Exception\Command;

use Throwable;
use App\Common\Application\Command\CommandException;

class UserLoginFailedException extends CommandException
{
    /**
     * UserLoginFailedException Constructor
     *
     * @param string $userFriendlyTitle
     * @param string $userFriendlyMessage
     * @param array $errors
     * @param string $message
     * @param integer $code
     * @param Throwable $previous
     */
    public function __construct($userFriendlyTitle = 'User login failed', $userFriendlyMessage = 'User login failed', $errors = [], $message = 'User login failed', $code = 0, Throwable $previous = null)
    {
        parent::__construct($userFriendlyTitle, $userFriendlyMessage, $errors, $message, $code, $previous);
    }
}
