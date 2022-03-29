<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Schedule;

use AndrewSvirin\ScheduleExpression\Domain\Exception\ExpressionException;
use AndrewSvirin\ScheduleExpression\Domain\Field\DateField;
use AndrewSvirin\ScheduleExpression\Domain\Field\DayOfWeekField;
use AndrewSvirin\ScheduleExpression\Domain\Field\TimeField;
use AndrewSvirin\ScheduleExpression\Domain\Field\TypeField;
use AndrewSvirin\ScheduleExpression\Domain\Field\TypeFieldInterface;

/**
 * Resolver for schedules.
 * @internal
 */
class ScheduleResolver
{
    /**
     * @var ScheduleCreator
     */
    private $scheduleCreator;

    public function __construct(ScheduleCreator $scheduleCreator)
    {
        $this->scheduleCreator = $scheduleCreator;
    }

    /**
     * @throws ExpressionException
     */
    public function resolve(
        TypeField $typeField,
        TimeField $timeField,
        DateField $dateField,
        DayOfWeekField $dayOfWeekField
    ): ScheduleInterface {
        switch ($typeField->getType()) {
            case TypeFieldInterface::DAY:
                $schedule = $this->scheduleCreator->createDayOfMonth(
                    $typeField,
                    $timeField,
                    $dateField,
                    $dayOfWeekField
                );
                break;
            case TypeFieldInterface::WEEK:
                $schedule = $this->scheduleCreator->createDayOfWeek(
                    $typeField,
                    $timeField,
                    $dateField,
                    $dayOfWeekField
                );
                break;
            case TypeFieldInterface::HOLIDAY:
                $schedule = $this->scheduleCreator->createHoliday(
                    $typeField,
                    $timeField,
                    $dateField,
                    $dayOfWeekField
                );
                break;
            default:
                throw new ExpressionException('Schedule was not recognized');
        }

        return $schedule;
    }
}
