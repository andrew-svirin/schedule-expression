<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Field;

/**
 * Public Express type field.
 * @internal
 */
interface TypeFieldInterface extends FieldInterface
{
    const WEEK = 'W';
    const DAY = 'D';
    const HOLIDAY = 'H';

    public function getType(): string;
}
