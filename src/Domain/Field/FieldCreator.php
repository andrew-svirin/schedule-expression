<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Field;

/**
 * Field factory.
 * @internal
 */
class FieldCreator
{
    public function createTypeField(): TypeField
    {
        return new TypeField();
    }

    public function createTimeField(): TimeField
    {
        return new TimeField();
    }

    public function createDateField(): DateField
    {
        return new DateField();
    }

    public function createDayOfWeekField(): DayOfWeekField
    {
        return new DayOfWeekField();
    }
}
