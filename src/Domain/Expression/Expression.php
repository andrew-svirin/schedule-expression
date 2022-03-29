<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Expression;

use AndrewSvirin\ScheduleExpression\Domain\Exception\ExpressionException;
use AndrewSvirin\ScheduleExpression\Domain\Schedule\DayOfMonthSchedule;
use AndrewSvirin\ScheduleExpression\Domain\Schedule\DayOfWeekSchedule;
use AndrewSvirin\ScheduleExpression\Domain\Schedule\HolidaySchedule;
use AndrewSvirin\ScheduleExpression\Domain\Schedule\ScheduleInterface;

/**
 * Express schedules.
 * @internal
 */
class Expression implements ExpressionInterface
{
    /**
     * @var ScheduleInterface[]
     */
    private $schedules = [];

    public function addSchedule(ScheduleInterface $schedule): self
    {
        $this->schedules[] = $schedule;

        return $this;
    }

    /**
     * @throws ExpressionException
     */
    public function deleteSchedule(int $id): self
    {
        if (!isset($this->schedules[$id])) {
            throw new ExpressionException('Schedule not found by id');
        }
        unset($this->schedules[$id]);

        return $this;
    }

    public function getSchedules(): array
    {
        return $this->schedules;
    }

    /**
     * @return HolidaySchedule[]
     */
    public function filterHolidaySchedules(): array
    {
        return array_filter($this->schedules, function (ScheduleInterface $schedule) {
            return $schedule instanceof HolidaySchedule;
        });
    }

    /**
     * @return DayOfMonthSchedule[]
     */
    public function filterDayOfMonthSchedules(): array
    {
        return array_filter($this->schedules, function (ScheduleInterface $schedule) {
            return $schedule instanceof DayOfMonthSchedule;
        });
    }

    /**
     * @return DayOfWeekSchedule[]
     */
    public function filterDayOfWeekSchedules(): array
    {
        return array_filter($this->schedules, function (ScheduleInterface $schedule) {
            return $schedule instanceof DayOfWeekSchedule;
        });
    }
}
