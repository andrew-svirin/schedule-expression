<?php

namespace AndrewSvirin\ScheduleExpression\Domain\FieldValue;

/**
 * Value object for day of week.
 * @internal
 */
class DayOfWeekFieldValue
{
    /**
     * @var int
     */
    private $dayOfWeek;

    public function __construct(int $dayOfWeek)
    {
        $this->dayOfWeek = $dayOfWeek;
    }

    public function getDayOfWeek(): int
    {
        return $this->dayOfWeek;
    }
}
