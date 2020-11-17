<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AntiSpamValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\AntiSpam */

        if (null === $value || '' === $value) {
            return;
        }

        return;
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value->getTitle())
            ->addViolation();
    }
}
