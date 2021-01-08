<?php

namespace App\Shopsy\IdentityAccess\Main\Application\Exception\Query;

use App\Common\Application\Query\QueryException;
use Throwable;
use App\Common\Domain\Validator\ValidationNotificationHandler;

class ValidationErrorQueryException extends QueryException
{
    /**
     * ValidationErrorQueryException Constructor
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

        return new ValidationErrorQueryException($title, $message, $validationNotificationHandler->getErrors(), sprintf('%s. %s', $title, $message));
    }
}
