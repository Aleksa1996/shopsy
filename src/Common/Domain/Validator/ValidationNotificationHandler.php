<?php

namespace App\Common\Domain\Validator;


class ValidationNotificationHandler
{
    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @param string $message
     * @param string $propertyPath
     *
     * @return self
     */
    public function addError($message, $propertyPath = null)
    {
        $this->errors[] = ['propertyPath' => $propertyPath, 'message' => $message];

        return $this;
    }

    /**
     * @return boolean
     */
    public function hasErrors()
    {
        return count($this->errors) > 0;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return array
     */
    public function getFirstError()
    {
        return $this->errors[0] ?? null;
    }
}
