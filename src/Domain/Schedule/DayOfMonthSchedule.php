<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Schedule;

use AndrewSvirin\ScheduleExpression\Domain\Field\TypeFieldInterface;

/**
 * Specifying schedule for day of month.
 * @internal
 */
class DayOfMonthSchedule extends Schedule
{
    protected function init(): void
    {
        parent::init();
        $this->typeField->setType(TypeFieldInterface::DAY);
    }
}
