<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Expression\Validator;

/**
 * Factory for model @see FieldValidationResult
 * @internal
 */
class ExpressionValidationResultCreator
{
    public function create(): ExpressionValidationResult
    {
        return new ExpressionValidationResult();
    }
}
