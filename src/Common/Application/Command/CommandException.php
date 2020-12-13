<?php

namespace App\Common\Application\Command;

use App\Common\Domain\Validator\ValidationNotificationHandler;
use Throwable;

class CommandException extends \Exception
{
    /**
     * @var string
     */
    protected $userFriendlyTitle;

    /**
     * @var string
     */
    protected $userFriendlyMessage;

    /**
     * @var array
     */
    protected $errors;

    /**
     * CommandException Constructor
     *
     * @param string $userFriendlyTitle
     * @param string $userFriendlyMessage
     * @param array $errors
     * @param string $message
     * @param integer $code
     * @param Throwable $previous
     */
    public function __construct($userFriendlyTitle, $userFriendlyMessage, $errors = [], $message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->userFriendlyTitle = $userFriendlyTitle;
        $this->userFriendlyMessage = $userFriendlyMessage;
        $this->errors = $errors;
    }

    /**
     * @return  string
     */
    public function getUserFriendlyTitle()
    {
        return $this->userFriendlyTitle;
    }

    /**
     * @return  string
     */
    public function getUserFriendlyMessage()
    {
        return $this->userFriendlyMessage;
    }

    /**
     * @return  array
     */
    public function getErrors()
    {
        return $this->errors;
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

        return new static($title, $message, $validationNotificationHandler->getErrors(), sprintf('%s. %s', $title, $message));
    }
}
