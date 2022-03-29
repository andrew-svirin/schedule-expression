<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Schedule;

use AndrewSvirin\ScheduleExpression\Domain\Exception\ExpressionException;
use AndrewSvirin\ScheduleExpression\Domain\Field\FieldDecoder;

/**
 * Parser for schedule.
 * @internal
 */
class ScheduleDecoder
{
    /**
     * @var ScheduleResolver
     */
    private $scheduleResolver;
    /**
     * @var FieldDecoder
     */
    private $fieldDecoder;

    public function __construct(ScheduleResolver $scheduleResolver, FieldDecoder $fieldDecoder)
    {
        $this->scheduleResolver = $scheduleResolver;
        $this->fieldDecoder = $fieldDecoder;
    }

    /**
     * @throws ExpressionException
     */
    public function decode(string $encodedSchedule): ScheduleInterface
    {
        if (!preg_match(ScheduleInterface::SCHEDULE_PATTERN, $encodedSchedule, $encodedFields)) {
            throw new ExpressionException('Can not match pattern of schedule');
        }

        $typeField = $this->fieldDecoder->decodeTypeField($encodedFields['type']);
        $timeField = $this->fieldDecoder->decodeTimeField($encodedFields['time']);
        $dateField = $this->fieldDecoder->decodeDateField($encodedFields['date']);
        $dayOfWeekField = $this->fieldDecoder->decodeDayOfWeekField($encodedFields['day_of_week']);

        return $this->scheduleResolver->resolve($typeField, $timeField, $dateField, $dayOfWeekField);
    }
}
