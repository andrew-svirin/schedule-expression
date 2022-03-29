<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Field;

/**
 * Field encoder.
 * @internal
 */
class FieldEncoder
{
    public function encodeTypeField(TypeFieldInterface $field): string
    {
        return $field->getType();
    }

    public function encodeTimeField(TimeFieldInterface $field): string
    {
        if ($field->isRange()) {
            return sprintf(
                FieldInterface::FIELD_TIME_RANGE_FORMAT,
                $field->getStartHour(),
                $field->getStartMinute() ?? 0,
                $field->getEndHour(),
                $field->getEndMinute() ?? 0
            );
        } else {
            return FieldInterface::FIELD_ANY;
        }
    }

    public function encodeDateField(DateFieldInterface $field): string
    {
        if ($field->isRange()) {
            return sprintf(
                FieldInterface::FIELD_DATE_RANGE_FORMAT,
                $field->getStartDay(),
                $field->getStartMonth(),
                $field->getStartYear(),
                $field->getEndDay(),
                $field->getEndMonth(),
                $field->getEndYear(),
            );
        } elseif ($field->isSingle()) {
            return sprintf(
                FieldInterface::FIELD_DATE_SINGLE_FORMAT,
                $field->getStartDay(),
                $field->getStartMonth(),
                $field->getStartYear(),
            );
        } else {
            return FieldInterface::FIELD_ANY;
        }
    }

    public function encodeDayOfWeekField(DayOfWeekFieldInterface $field): string
    {
        if ($field->isRange()) {
            return sprintf(
                FieldInterface::FIELD_DAY_OF_WEEK_RANGE_FORMAT,
                $field->getStartDayOfWeek(),
                $field->getEndDayOfWeek()
            );
        } elseif ($field->isSingle()) {
            return sprintf(
                FieldInterface::FIELD_DAY_OF_WEEK_SINGLE_FORMAT,
                $field->getStartDayOfWeek()
            );
        } else {
            return FieldInterface::FIELD_ANY;
        }
    }
}
