<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Field;

/**
 * Express day of week field.
 * @internal
 */
class DayOfWeekField extends Field implements DayOfWeekFieldInterface
{
    /**
     * @var int|null
     */
    private $startDayOfWeek;
    /**
     * @var int|null
     */
    private $endDayOfWeek;

    public function getStartDayOfWeek(): ?int
    {
        return $this->startDayOfWeek;
    }

    public function setStartDayOfWeek(int $day): void
    {
        $this->startDayOfWeek = $day;
    }

    public function getEndDayOfWeek(): ?int
    {
        return $this->endDayOfWeek;
    }

    public function setEndDayOfWeek(int $day): void
    {
        $this->endDayOfWeek = $day;
    }

    public function isRange(): bool
    {
        return null !== $this->startDayOfWeek && $this->startDayOfWeek !== $this->endDayOfWeek;
    }

    public function isSingle(): bool
    {
        return null !== $this->startDayOfWeek && $this->startDayOfWeek === $this->endDayOfWeek;
    }

    public function isAny(): bool
    {
        return null === $this->startDayOfWeek || null === $this->endDayOfWeek;
    }
}
