<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Schedule;

use AndrewSvirin\ScheduleExpression\Domain\Field\TypeFieldInterface;

/**
 * Specifying schedule for day of week.
 * @internal
 */
class DayOfWeekSchedule extends Schedule
{
    protected function init(): void
    {
        parent::init();
        $this->typeField->setType(TypeFieldInterface::WEEK);
    }
}
