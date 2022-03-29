<?php

namespace AndrewSvirin\ScheduleExpression\Domain\ScheduleValue;

use AndrewSvirin\ScheduleExpression\Domain\FieldValue\DateFieldValue;
use AndrewSvirin\ScheduleExpression\Domain\FieldValue\DayOfWeekFieldValue;
use AndrewSvirin\ScheduleExpression\Domain\FieldValue\TimeFieldValue;

/**
 * Collection of the values.
 * @internal
 */
class ScheduleValue
{
    /**
     * @var DateFieldValue
     */
    private $date;
    /**
     * @var TimeFieldValue
     */
    private $time;
    /**
     * @var DayOfWeekFieldValue
     */
    private $dayOfWeek;

    public function __construct(DateFieldValue $date, TimeFieldValue $time, DayOfWeekFieldValue $dayOfWeek)
    {
        $this->date = $date;
        $this->time = $time;
        $this->dayOfWeek = $dayOfWeek;
    }

    public function getDate(): DateFieldValue
    {
        return $this->date;
    }

    public function getTime(): TimeFieldValue
    {
        return $this->time;
    }

    public function getDayOfWeek(): DayOfWeekFieldValue
    {
        return $this->dayOfWeek;
    }
}
