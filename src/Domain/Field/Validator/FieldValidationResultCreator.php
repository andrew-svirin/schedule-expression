<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Field\Validator;

/**
 * Factory for model @see FieldValidationResult
 * @internal
 */
class FieldValidationResultCreator
{
    public function create(): FieldValidationResult
    {
        return new FieldValidationResult();
    }
}
