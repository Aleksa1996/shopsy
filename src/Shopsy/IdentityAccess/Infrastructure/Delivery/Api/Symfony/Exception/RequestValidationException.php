<?php


namespace App\Shopsy\IdentityAccess\Infrastructure\Delivery\Api\Symfony\Exception;


use Exception;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

class RequestValidationException extends Exception
{
    private $violationList;

    public function __construct(ConstraintViolationListInterface $violationList, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
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