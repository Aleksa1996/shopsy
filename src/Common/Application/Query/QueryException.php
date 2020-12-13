<?php

namespace App\Common\Application\Query;

use Throwable;


class QueryException extends \Exception
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
}
