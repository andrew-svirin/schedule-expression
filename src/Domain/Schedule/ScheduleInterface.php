<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Schedule;

use AndrewSvirin\ScheduleExpression\Domain\Field\DateField;
use AndrewSvirin\ScheduleExpression\Domain\Field\DayOfWeekField;
use AndrewSvirin\ScheduleExpression\Domain\Field\TimeField;
use AndrewSvirin\ScheduleExpression\Domain\Field\TypeField;

/**
 * Public General schedule.
 * @internal
 */
interface ScheduleInterface
{
    const SCHEDULE_FORMAT = '%s %s %s %s';
    const SCHEDULE_PATTERN = '/^(?<type>\S+) (?<time>\S+) (?<date>\S+) (?<day_of_week>\S+)$/';

    public function getTypeField(): TypeField;

    public function getTimeField(): TimeField;

    public function getDateField(): DateField;

    public function getDayOfWeekField(): DayOfWeekField;
}
