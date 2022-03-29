<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Field;

use AndrewSvirin\ScheduleExpression\Domain\FieldValue\DateFieldValue;
use AndrewSvirin\ScheduleExpression\Domain\FieldValue\DayOfWeekFieldValue;
use AndrewSvirin\ScheduleExpression\Domain\FieldValue\TimeFieldValue;

/**
 * Field evaluator.
 * @internal
 */
class FieldEvaluator
{
    /**
     * @example schedule time 10:30-18:00 & current time 10:20
     */
    public function isTimeFieldDue(TimeFieldInterface $field, TimeFieldValue $fieldValue): bool
    {
        if ($field->isRange()) {
            // 10:xx > t > 18:xx
            if ($fieldValue->getHour() < $field->getStartHour() ||
                $fieldValue->getHour() > $field->getEndHour()) {
                return false;
            }

            // t < 10:30
            if ($fieldValue->getHour() === $field->getStartHour() &&
                $fieldValue->getMinute() < $field->getStartMinute()) {
                return false;
            }

            // t >= 18:00
            if ($fieldValue->getHour() === $field->getEndHour() &&
                $fieldValue->getMinute() >= $field->getEndMinute()) {
                return false;
            }
        }

        return true;
    }

    /**
     * @example schedule date 08.03.2021 & current date 09.03.2021
     * @example schedule date 01.01.2021-07.01.2021 & current date 08.01.2021
     */
    public function isDateFieldDue(DateFieldInterface $field, DateFieldValue $fieldValue): bool
    {
        if ($field->isRange()) {
            // xx.xx.2021 > d > xx.xx.2021
            if ($fieldValue->getYear() < $field->getStartYear() ||
                $fieldValue->getYear() > $field->getEndYear()) {
                return false;
            }

            // d < xx.01.2021
            if ($fieldValue->getYear() === $field->getStartYear() &&
                $fieldValue->getMonth() < $field->getStartMonth()) {
                return false;
            }

            // d > xx.01.2021
            if ($fieldValue->getYear() === $field->getEndYear() &&
                $fieldValue->getMonth() > $field->getEndMonth()) {
                return false;
            }

            // d < 01.01.2021
            if ($fieldValue->getYear() === $field->getStartYear() &&
                $fieldValue->getMonth() === $field->getStartMonth() &&
                $fieldValue->getDay() < $field->getStartDay()) {
                return false;
            }

            // d > 07.01.2021
            if ($fieldValue->getYear() === $field->getEndYear() &&
                $fieldValue->getMonth() === $field->getEndMonth() &&
                $fieldValue->getDay() > $field->getEndDay()) {
                return false;
            }
        } elseif ($field->isSingle()) {
            // d <> xx.xx.2021
            if ($fieldValue->getYear() !== $field->getStartYear()) {
                return false;
            }

            // d <> xx.03.2021
            if ($fieldValue->getMonth() !== $field->getStartMonth()) {
                return false;
            }

            // d <> 08.03.2021
            if ($fieldValue->getDay() !== $field->getStartDay()) {
                return false;
            }
        }

        return true;
    }

    /**
     * @example schedule day of week 6 & current day of week 7
     * @example schedule day of week 1-5 & current day of week 6
     */
    public function isDayOfWeekFieldDue(DayOfWeekFieldInterface $field, DayOfWeekFieldValue $fieldValue): bool
    {
        if ($field->isRange()) {
            // 1 > N > 5
            if ($fieldValue->getDayOfWeek() < $field->getStartDayOfWeek() ||
                $fieldValue->getDayOfWeek() > $field->getEndDayOfWeek()) {
                return false;
            }
        } elseif ($field->isSingle()) {
            // N <> 6
            if ($fieldValue->getDayOfWeek() !== $field->getStartDayOfWeek()) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return int
     *  -1 - before bound
     *  0  - in bound
     *  1  - after bound
     * @example field 10:30-18:00 and value 11:00
     */
    public function compareTimeField(TimeFieldInterface $field, TimeFieldValue $fieldValue): int
    {
        // If 00:00 then will think it is start of any day. And first minute should return -1.
        if (0 === $fieldValue->getHour() && 0 === $fieldValue->getMinute()) {
            return -1;
        }

        // t < 10:xx
        if ($fieldValue->getHour() < $field->getStartHour()) {
            return -1;
        }

        // t < 10:30
        if ($fieldValue->getHour() === $field->getStartHour() && $fieldValue->getMinute() < $field->getStartMinute()) {
            return -1;
        }

        // t > 18:xx
        if ($fieldValue->getHour() > $field->getEndHour()) {
            return 1;
        }

        // t >= 18:00
        if ($fieldValue->getHour() === $field->getEndHour() && $fieldValue->getMinute() >= $field->getEndMinute()) {
            return 1;
        }

        return 0;
    }
}
