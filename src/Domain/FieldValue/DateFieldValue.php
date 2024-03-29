<?php

namespace AndrewSvirin\ScheduleExpression\Domain\FieldValue;

/**
 * Value object for date.
 * @internal
 */
class DateFieldValue
{
    /**
     * @var int
     */
    private $day;
    /**
     * @var int
     */
    private $month;
    /**
     * @var int
     */
    private $year;

    public function __construct(int $day, int $month, int $year)
    {
        $this->day = $day;
        $this->month = $month;
        $this->year = $year;
    }

    public function getDay(): int
    {
        return $this->day;
    }

    public function getMonth(): int
    {
        return $this->month;
    }

    public function getYear(): int
    {
        return $this->year;
    }
}
