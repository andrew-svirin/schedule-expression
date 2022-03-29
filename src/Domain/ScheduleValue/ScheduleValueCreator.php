<?php

namespace AndrewSvirin\ScheduleExpression\Domain\ScheduleValue;

use AndrewSvirin\ScheduleExpression\Domain\FieldValue\DateFieldValue;
use AndrewSvirin\ScheduleExpression\Domain\FieldValue\DayOfWeekFieldValue;
use AndrewSvirin\ScheduleExpression\Domain\FieldValue\TimeFieldValue;

/**
 * Factory for schedule value.
 * @internal
 */
class ScheduleValueCreator
{
    public function create(
        DateFieldValue $date,
        TimeFieldValue $time,
        DayOfWeekFieldValue $dayOfWeek
    ): ScheduleValue {
        return new ScheduleValue($date, $time, $dayOfWeek);
    }
}
