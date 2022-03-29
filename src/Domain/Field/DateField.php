<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Field;

/**
 * Express date field.
 * @internal
 */
class DateField extends Field implements DateFieldInterface
{
    /**
     * @var int|null
     */
    private $startDay;
    /**
     * @var int|null
     */
    private $startMonth;
    /**
     * @var int|null
     */
    private $startYear;
    /**
     * @var int|null
     */
    private $endDay;
    /**
     * @var int|null
     */
    private $endMonth;
    /**
     * @var int|null
     */
    private $endYear;

    public function getStartDay(): ?int
    {
        return $this->startDay;
    }

    public function setStartDay(int $day): void
    {
        $this->startDay = $day;
    }

    public function getStartMonth(): ?int
    {
        return $this->startMonth;
    }

    public function setStartMonth(int $month): void
    {
        $this->startMonth = $month;
    }

    public function getStartYear(): ?int
    {
        return $this->startYear;
    }

    public function setStartYear(int $year): void
    {
        $this->startYear = $year;
    }

    public function getEndDay(): ?int
    {
        return $this->endDay;
    }

    public function setEndDay(int $day): void
    {
        $this->endDay = $day;
    }

    public function getEndMonth(): ?int
    {
        return $this->endMonth;
    }

    public function setEndMonth(int $month): void
    {
        $this->endMonth = $month;
    }

    public function getEndYear(): ?int
    {
        return $this->endYear;
    }

    public function setEndYear(int $year): void
    {
        $this->endYear = $year;
    }

    public function isRange(): bool
    {
        return null !== $this->startDay &&
            null !== $this->startMonth &&
            null !== $this->startYear &&
            ($this->startDay !== $this->endDay ||
                $this->startMonth !== $this->endMonth ||
                $this->startYear !== $this->endYear);
    }

    public function isSingle(): bool
    {
        return null !== $this->startDay &&
            null !== $this->startMonth &&
            null !== $this->startYear &&
            $this->startDay === $this->endDay &&
            $this->startMonth === $this->endMonth &&
            $this->startYear === $this->endYear;
    }

    public function isAny(): bool
    {
        return null === $this->startDay ||
            null === $this->startMonth ||
            null === $this->startYear ||
            null === $this->endDay ||
            null === $this->endMonth ||
            null === $this->endYear;
    }
}
