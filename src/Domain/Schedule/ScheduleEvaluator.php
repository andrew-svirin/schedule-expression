<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Schedule;

use DateTime;
use AndrewSvirin\ScheduleExpression\Domain\Exception\ExpressionException;
use AndrewSvirin\ScheduleExpression\Domain\Field\FieldCreator;
use AndrewSvirin\ScheduleExpression\Domain\Field\FieldEvaluator;
use AndrewSvirin\ScheduleExpression\Domain\ScheduleValue\ScheduleValueConverter;

/**
 * Schedule evaluator.
 * @internal
 */
class ScheduleEvaluator
{
    /**
     * @var FieldEvaluator
     */
    private $fieldEvaluator;
    /**
     * @var FieldCreator
     */
    private $fieldCreator;
    /**
     * @var ScheduleValueConverter
     */
    private $scheduleValueConverter;
    /**
     * @var ScheduleResolver
     */
    private $scheduleResolver;

    public function __construct(
        FieldEvaluator $fieldEvaluator,
        FieldCreator $fieldCreator,
        ScheduleValueConverter $scheduleValueConverter,
        ScheduleResolver $scheduleResolver
    ) {
        $this->fieldEvaluator = $fieldEvaluator;
        $this->fieldCreator = $fieldCreator;
        $this->scheduleValueConverter = $scheduleValueConverter;
        $this->scheduleResolver = $scheduleResolver;
    }

    /**
     * Determinate that schedule is due for the time.
     */
    public function isDue(ScheduleInterface $schedule, DateTime $now): bool
    {
        $scheduleValue = $this->scheduleValueConverter->convertToScheduleValue($now);

        // Order of conditions is important.
        return $this->fieldEvaluator
                ->isDayOfWeekFieldDue($schedule->getDayOfWeekField(), $scheduleValue->getDayOfWeek()) &&
            $this->fieldEvaluator
                ->isDateFieldDue($schedule->getDateField(), $scheduleValue->getDate()) &&
            $this->fieldEvaluator
                ->isTimeFieldDue($schedule->getTimeField(), $scheduleValue->getTime());
    }

    /**
     * @throws ExpressionException
     */
    public function resolveLastDateOfHoliday(HolidaySchedule $schedule): DateTime
    {
        $dateTime = new DateTime();
        $year = $schedule->getDateField()->getEndYear();
        $month = $schedule->getDateField()->getEndMonth();
        $day = $schedule->getDateField()->getEndDay();
        if (null === $year || null === $month || null === $day) {
            throw new ExpressionException('Holiday Schedule error');
        }
        $dateTime->setDate($year, $month, $day);

        return $dateTime;
    }

    /**
     * @throws ExpressionException
     */
    public function resolveScheduleIgnoringTime(ScheduleInterface $schedule): ScheduleInterface
    {
        return $this->scheduleResolver->resolve(
            $schedule->getTypeField(),
            $this->fieldCreator->createTimeField(),
            $schedule->getDateField(),
            $schedule->getDayOfWeekField()
        );
    }

    public function isNowBeforeScheduleTime(ScheduleInterface $schedule, DateTime $now): bool
    {
        $scheduleValue = $this->scheduleValueConverter->convertToScheduleValue($now);
        $cmpTimeField = $this->fieldEvaluator->compareTimeField($schedule->getTimeField(), $scheduleValue->getTime());

        return -1 === $cmpTimeField;
    }

    /**
     * @throws ExpressionException
     */
    public function resolveScheduleStartDateTime(ScheduleInterface $schedule, DateTime $now): DateTime
    {
        $startDateTime = clone $now;
        $hour = $schedule->getTimeField()->getStartHour();
        $minute = $schedule->getTimeField()->getStartMinute();
        if (null === $hour || null === $minute) {
            throw new ExpressionException('Schedule error');
        }
        $startDateTime->setTime($hour, $minute);

        return $startDateTime;
    }
}
