<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Field;

/**
 * Public Express time field.
 * @internal
 */
interface TimeFieldInterface extends FieldInterface
{
    public function getStartHour(): ?int;

    public function getStartMinute(): ?int;

    public function getEndHour(): ?int;

    public function getEndMinute(): ?int;

    public function isRange(): bool;

    public function isAny(): bool;
}
