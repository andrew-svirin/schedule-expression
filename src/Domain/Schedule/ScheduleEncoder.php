<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Schedule;

use AndrewSvirin\ScheduleExpression\Domain\Field\FieldEncoder;

/**
 * Encoder for schedule.
 * @internal
 */
class ScheduleEncoder
{
    /**
     * @var FieldEncoder
     */
    private $fieldEncoder;

    public function __construct(FieldEncoder $fieldEncoder)
    {
        $this->fieldEncoder = $fieldEncoder;
    }

    public function encode(ScheduleInterface $schedule): string
    {
        $type = $this->fieldEncoder->encodeTypeField($schedule->getTypeField());
        $time = $this->fieldEncoder->encodeTimeField($schedule->getTimeField());
        $date = $this->fieldEncoder->encodeDateField($schedule->getDateField());
        $dayOfWeek = $this->fieldEncoder->encodeDayOfWeekField($schedule->getDayOfWeekField());

        return sprintf(ScheduleInterface::SCHEDULE_FORMAT, $type, $time, $date, $dayOfWeek);
    }
}
