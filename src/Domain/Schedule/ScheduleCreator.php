<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Schedule;

use AndrewSvirin\ScheduleExpression\Domain\Field\DateField;
use AndrewSvirin\ScheduleExpression\Domain\Field\DayOfWeekField;
use AndrewSvirin\ScheduleExpression\Domain\Field\FieldCreator;
use AndrewSvirin\ScheduleExpression\Domain\Field\TimeField;
use AndrewSvirin\ScheduleExpression\Domain\Field\TypeField;

/**
 * Factory for schedules.
 * @internal
 */
class ScheduleCreator
{
    /**
     * @var FieldCreator
     */
    private $fieldCreator;

    public function __construct(FieldCreator $fieldCreator)
    {
        $this->fieldCreator = $fieldCreator;
    }

    public function createDayOfMonth(
        TypeField $typeField = null,
        TimeField $timeField = null,
        DateField $dateField = null,
        DayOfWeekField $dayOfWeekField = null
    ): DayOfMonthSchedule {
        return new DayOfMonthSchedule(
            $typeField ?? $this->fieldCreator->createTypeField(),
            $timeField ?? $this->fieldCreator->createTimeField(),
            $dateField ?? $this->fieldCreator->createDateField(),
            $dayOfWeekField ?? $this->fieldCreator->createDayOfWeekField()
        );
    }

    public function createDayOfWeek(
        TypeField $typeField = null,
        TimeField $timeField = null,
        DateField $dateField = null,
        DayOfWeekField $dayOfWeekField = null
    ): DayOfWeekSchedule {
        return new DayOfWeekSchedule(
            $typeField ?? $this->fieldCreator->createTypeField(),
            $timeField ?? $this->fieldCreator->createTimeField(),
            $dateField ?? $this->fieldCreator->createDateField(),
            $dayOfWeekField ?? $this->fieldCreator->createDayOfWeekField()
        );
    }

    public function createHoliday(
        TypeField $typeField = null,
        TimeField $timeField = null,
        DateField $dateField = null,
        DayOfWeekField $dayOfWeekField = null
    ): HolidaySchedule {
        return new HolidaySchedule(
            $typeField ?? $this->fieldCreator->createTypeField(),
            $timeField ?? $this->fieldCreator->createTimeField(),
            $dateField ?? $this->fieldCreator->createDateField(),
            $dayOfWeekField ?? $this->fieldCreator->createDayOfWeekField()
        );
    }
}
