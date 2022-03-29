<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Schedule;

use AndrewSvirin\ScheduleExpression\Domain\Field\DateField;
use AndrewSvirin\ScheduleExpression\Domain\Field\DayOfWeekField;
use AndrewSvirin\ScheduleExpression\Domain\Field\TimeField;
use AndrewSvirin\ScheduleExpression\Domain\Field\TypeField;

/**
 * General schedule.
 * @internal
 */
abstract class Schedule implements ScheduleInterface
{
    /**
     * @var TypeField
     */
    protected $typeField;
    /**
     * @var TimeField
     */
    protected $timeField;
    /**
     * @var DateField
     */
    protected $dateField;
    /**
     * @var DayOfWeekField
     */
    protected $dayOfWeekField;

    public function __construct(
        TypeField $typeField,
        TimeField $timeField,
        DateField $dateField,
        DayOfWeekField $dayOfWeekField
    ) {
        $this->typeField = $typeField;
        $this->timeField = $timeField;
        $this->dateField = $dateField;
        $this->dayOfWeekField = $dayOfWeekField;
        $this->init();
    }

    public function getTypeField(): TypeField
    {
        return $this->typeField;
    }

    public function getTimeField(): TimeField
    {
        return $this->timeField;
    }

    public function getDateField(): DateField
    {
        return $this->dateField;
    }

    public function getDayOfWeekField(): DayOfWeekField
    {
        return $this->dayOfWeekField;
    }

    protected function init(): void
    {
    }

    public function setFromTime(int $hour, int $minute = null): self
    {
        $this->timeField->setStartHour($hour);
        $this->timeField->setStartMinute($minute ?? 0);

        return $this;
    }

    public function setToTime(int $hour, int $minute = null): self
    {
        $this->timeField->setEndHour($hour);
        $this->timeField->setEndMinute($minute ?? 0);

        return $this;
    }

    public function setDate(int $day, int $month, int $year): self
    {
        $this->dateField->setStartDay($day);
        $this->dateField->setStartMonth($month);
        $this->dateField->setStartYear($year);
        $this->dateField->setEndDay($day);
        $this->dateField->setEndMonth($month);
        $this->dateField->setEndYear($year);

        return $this;
    }

    public function setFromDate(int $day, int $month, int $year): self
    {
        $this->dateField->setStartDay($day);
        $this->dateField->setStartMonth($month);
        $this->dateField->setStartYear($year);

        return $this;
    }

    public function setToDate(int $day, int $month, int $year): self
    {
        $this->dateField->setEndDay($day);
        $this->dateField->setEndMonth($month);
        $this->dateField->setEndYear($year);

        return $this;
    }

    public function setDayOfWeek(int $dayOfWeek): self
    {
        $this->dayOfWeekField->setStartDayOfWeek($dayOfWeek);
        $this->dayOfWeekField->setEndDayOfWeek($dayOfWeek);

        return $this;
    }

    public function setFromDayOfWeek(int $dayOfWeek): self
    {
        $this->dayOfWeekField->setStartDayOfWeek($dayOfWeek);

        return $this;
    }

    public function setToDayOfWeek(int $dayOfWeek): self
    {
        $this->dayOfWeekField->setEndDayOfWeek($dayOfWeek);

        return $this;
    }
}
