<?php

namespace App\Common\Infrastructure\Delivery\Symfony\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class AtLeastOneValidField extends Constraint
{
    /**
     * @var string
     */
    public $message = 'At least one field must be filled in.';

    /**
     * @inheritDoc
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
