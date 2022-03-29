<?php

namespace AndrewSvirin\ScheduleExpression\Domain\FieldValue;

/**
 * Value object for time.
 * @internal
 */
class TimeFieldValue
{
    /**
     * @var int
     */
    private $hour;
    /**
     * @var int
     */
    private $minute;

    public function __construct(int $hour, int $minute)
    {
        $this->hour = $hour;
        $this->minute = $minute;
    }

    public function getHour(): int
    {
        return $this->hour;
    }

    public function getMinute(): int
    {
        return $this->minute;
    }
}
