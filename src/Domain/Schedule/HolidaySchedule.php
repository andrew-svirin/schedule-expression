<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Schedule;

use AndrewSvirin\ScheduleExpression\Domain\Field\TypeFieldInterface;

/**
 * Specifying schedule for holiday.
 * @internal
 */
class HolidaySchedule extends Schedule
{
    protected function init(): void
    {
        parent::init();
        $this->typeField->setType(TypeFieldInterface::HOLIDAY);
    }
}
