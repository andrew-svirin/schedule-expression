<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Field\Validator;

use AndrewSvirin\ScheduleExpression\Components\ValidatorInterface\ValidationResult;

/**
 * Model represent result of field validation.
 * @internal
 */
class FieldValidationResult extends ValidationResult
{
    public function addError(string $error): void
    {
        $this->errors[] = $error;
    }
}
