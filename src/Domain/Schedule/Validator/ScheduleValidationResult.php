<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Schedule\Validator;

use AndrewSvirin\ScheduleExpression\Components\ValidatorInterface\ValidationResult;

/**
 * Model represent result of schedule validation.
 * @internal
 */
class ScheduleValidationResult extends ValidationResult
{
    /**
     * @param array<array> $errors
     */
    public function addFieldErrors(string $fieldId, array $errors): void
    {
        $this->errors[$fieldId] = $errors;
    }
}
