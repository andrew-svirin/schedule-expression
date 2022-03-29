<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Field;

/**
 * Public Express day of week field.
 * @internal
 */
interface DayOfWeekFieldInterface extends FieldInterface
{
    public function getStartDayOfWeek(): ?int;

    public function getEndDayOfWeek(): ?int;

    public function isRange(): bool;

    public function isSingle(): bool;

    public function isAny(): bool;
}
