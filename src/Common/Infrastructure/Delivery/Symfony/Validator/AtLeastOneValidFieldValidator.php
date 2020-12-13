<?php

namespace App\Common\Infrastructure\Delivery\Symfony\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AtLeastOneValidFieldValidator extends ConstraintValidator
{
    /**
     * @param Object $object
     * @param Constraint $constraint
     *
     * @return void
     */
    public function validate($value, Constraint $constraint)
    {
        $objectVars = get_object_vars($value);

        $allFieldsAreEmpty = true;
        foreach ($objectVars as $objectVar) {
            if (!is_null($objectVar)) {
                $allFieldsAreEmpty = false;
                break;
            }
        }

        if ($allFieldsAreEmpty) {
            $this
                ->context
                ->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
