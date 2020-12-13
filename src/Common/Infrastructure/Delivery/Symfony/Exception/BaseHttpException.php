<?php

namespace App\Common\Infrastructure\Delivery\Symfony\Exception;

use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Common\Infrastructure\Delivery\Symfony\ResponseDto\ErrorDto;

class BaseHttpException extends HttpException
{
    /**
     * @var array
     */
    private $errors;

    /**
     * BaseHttpException Constructor
     *
     * @param array $errors
     * @param string $message
     * @param integer $code
     * @param array $headers
     * @param Throwable $previous
     */
    public function __construct($errors, $statusCode = 400, $message = null, $code = 0, $headers = [], Throwable $previous = null)
    {
        parent::__construct($statusCode, $message, $previous, $headers, $code);

        if (is_array($errors)) {
            $this->errors = $errors;
        } else {
            $this->errors = [$errors];
        }
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param ConstraintViolationList $constraintViolationList
     *
     * @return self
     */
    public static function createFromConstraintViolationList($constraintViolationList, $statusCode = 400, $message = 'Bad request', $code = 0, $headers = [], Throwable $previous = null)
    {
        $errors = [];

        foreach ($constraintViolationList as $constraintViolationListItem) {
            $pointer = ['pointer' => ''];
            if (!empty($constraintViolationListItem->getPropertyPath())) {
                $pointer = ['pointer' => sprintf('/data/attributes/%s', $constraintViolationListItem->getPropertyPath())];
            }

            $errors[] = new ErrorDto('Bad Request', $constraintViolationListItem->getMessage(), $pointer);
        }

        return new static($errors, $statusCode, $message, $code, $headers, $previous);
    }
}
