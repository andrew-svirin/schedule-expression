<?php

namespace AndrewSvirin\ScheduleExpression\Domain\FieldValue;

/**
 * Factory for field value.
 * @internal
 */
class FieldValueCreator
{
    public function createDate(int $day, int $month, int $year): DateFieldValue
    {
        return new DateFieldValue($day, $month, $year);
    }

    public function createTime(int $hour, int $minute): TimeFieldValue
    {
        return new TimeFieldValue($hour, $minute);
    }

    public function createDayOfWeek(int $dayOfWeek): DayOfWeekFieldValue
    {
        return new DayOfWeekFieldValue($dayOfWeek);
    }
}
