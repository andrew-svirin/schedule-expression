<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Expression\Validator;

use AndrewSvirin\ScheduleExpression\Components\ValidatorInterface\ValidationResult;

/**
 * Model represent result of expression validation.
 * @internal
 */
class ExpressionValidationResult extends ValidationResult
{
    /**
     * @param array<array> $errors
     */
    public function addScheduleErrors(int $scheduleId, array $errors): void
    {
        $this->errors[$scheduleId] = $errors;
    }
}
