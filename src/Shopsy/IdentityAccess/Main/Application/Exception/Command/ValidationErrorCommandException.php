<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Exception\Command;

use App\Common\Application\Command\CommandException;
use Throwable;
use App\Common\Domain\Validator\ValidationNotificationHandler;

class ValidationErrorCommandException extends CommandException
{
    /**
     * ValidationErrorCommandException Constructor
     *
     * @param string $userFriendlyTitle
     * @param string $userFriendlyMessage
     * @param array $errors
     * @param string $message
     * @param integer $code
     * @param Throwable $previous
     */
    public function __construct($userFriendlyTitle = 'Validation error', $userFriendlyMessage = 'Validation error', $errors = [], $message = 'Validation error', $code = 0, Throwable $previous = null)
    {
        parent::__construct($userFriendlyTitle, $userFriendlyMessage, $errors, $message, $code, $previous);
    }

    /**
     * @param ValidationNotificationHandler $validationNotificationHandler
     *
     * @return self
     */
    public static function createFromValidationNotificationHandler(ValidationNotificationHandler $validationNotificationHandler)
    {
        $title = 'Validation error';
        $message = 'Provided data is not valid';

        return new ValidationErrorCommandException($title, $message, $validationNotificationHandler->getErrors(), sprintf('%s. %s', $title, $message));
    }
}
