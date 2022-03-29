<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Schedule\Validator;

/**
 * Factory for model @see FieldValidationResult
 * @internal
 */
class ScheduleValidationResultCreator
{
    public function create(): ScheduleValidationResult
    {
        return new ScheduleValidationResult();
    }
}
