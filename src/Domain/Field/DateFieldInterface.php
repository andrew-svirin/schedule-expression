<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Field;

/**
 * Public Express date field.
 * @internal
 */
interface DateFieldInterface extends FieldInterface
{
    public function getStartDay(): ?int;

    public function getStartMonth(): ?int;

    public function getStartYear(): ?int;

    public function getEndDay(): ?int;

    public function getEndMonth(): ?int;

    public function getEndYear(): ?int;

    public function isRange(): bool;

    public function isSingle(): bool;

    public function isAny(): bool;
}
