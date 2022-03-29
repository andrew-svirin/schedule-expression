<?php

namespace AndrewSvirin\ScheduleExpression\Components\ValidatorInterface;

/**
 * General class for validation result.
 * @internal
 */
abstract class ValidationResult implements ValidationResultInterface
{
    /**
     * @var array
     */
    protected $errors = [];

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
