<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Expression;

use AndrewSvirin\ScheduleExpression\Domain\Schedule\ScheduleEncoder;

/**
 * Encoder for expression.
 * @internal
 */
class ExpressionEncoder
{
    /**
     * @var ScheduleEncoder
     */
    private $scheduleEncoder;

    public function __construct(ScheduleEncoder $scheduleEncoder)
    {
        $this->scheduleEncoder = $scheduleEncoder;
    }

    public function encode(ExpressionInterface $expression): string
    {
        $encodedSchedules = [];
        foreach ($expression->getSchedules() as $schedule) {
            $encodedSchedules[] = $this->scheduleEncoder->encode($schedule);
        }

        return $this->implode($encodedSchedules);
    }

    /**
     * @param string[] $encodedSchedules
     */
    private function implode(array $encodedSchedules): string
    {
        return implode(ExpressionInterface::SCHEDULE_DELIMITER, $encodedSchedules);
    }
}
