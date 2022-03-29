<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Field;

/**
 * Express time field.
 * @internal
 */
class TimeField extends Field implements TimeFieldInterface
{
    /**
     * @var int|null
     */
    private $startHour;
    /**
     * @var int|null
     */
    private $startMinute;
    /**
     * @var int|null
     */
    private $endHour;
    /**
     * @var int|null
     */
    private $endMinute;

    public function getStartHour(): ?int
    {
        return $this->startHour;
    }

    public function setStartHour(int $hour): void
    {
        $this->startHour = $hour;
    }

    public function getStartMinute(): ?int
    {
        return $this->startMinute;
    }

    public function setStartMinute(?int $minute): void
    {
        $this->startMinute = $minute;
    }

    public function getEndHour(): ?int
    {
        return $this->endHour;
    }

    public function setEndHour(int $hour): void
    {
        $this->endHour = $hour;
    }

    public function getEndMinute(): ?int
    {
        return $this->endMinute;
    }

    public function setEndMinute(?int $minute): void
    {
        $this->endMinute = $minute;
    }

    public function isRange(): bool
    {
        return null !== $this->startHour &&
            null !== $this->startMinute &&
            ($this->startHour !== $this->endHour ||
                $this->startMinute !== $this->endMinute);
    }

    public function isAny(): bool
    {
        return null === $this->startHour ||
            null === $this->startMinute ||
            null === $this->endHour ||
            null === $this->endMinute;
    }
}
