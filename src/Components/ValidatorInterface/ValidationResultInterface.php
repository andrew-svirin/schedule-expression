<?php

namespace AndrewSvirin\ScheduleExpression\Components\ValidatorInterface;

/**
 * Contract for use validation result
 * @internal
 */
interface ValidationResultInterface
{
    public function hasErrors(): bool;

    public function getErrors(): array;
}
