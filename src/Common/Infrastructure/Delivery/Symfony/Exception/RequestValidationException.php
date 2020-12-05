<?php

namespace App\Common\Infrastructure\Delivery\Symfony\Exception;


use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

class RequestValidationException extends HttpException
{
    /**
     * @var ConstraintViolationListInterface
     */
    private $violationList;

    /**
     * RequestValidationException Constructor
     *
     * @param ConstraintViolationListInterface $violationList
     * @param string $message
     * @param integer $code
     * @param array $headers
     * @param Throwable $previous
     */
    public function __construct(ConstraintViolationListInterface $violationList, $message = null, $code = 0, $headers = [], Throwable $previous = null)
    {
        parent::__construct(400, $message, $previous, $headers, $code);
        $this->violationList = $violationList;
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getViolationList()
    {
        return $this->violationList;
    }

    /**
     * @return array
     */
    public function getViolationListAsArray()
    {
        $violationListArray = [];

        foreach ($this->getViolationList() as $violationListItem) {
            $violationListArray[] = [
                'propertyPath' => $violationListItem->getPropertyPath(),
                'message' => $violationListItem->getMessage()
            ];
        }

        return $violationListArray;
    }
}
