<?php

namespace AndrewSvirin\ScheduleExpression\Domain\ScheduleValue;

use DateTime;
use AndrewSvirin\ScheduleExpression\Domain\FieldValue\FieldValueCreator;

/**
 * Convertor for schedule value.
 * @internal
 */
class ScheduleValueConverter
{
    /**
     * @var FieldValueCreator
     */
    private $fieldValueCreator;
    /**
     * @var ScheduleValueCreator
     */
    private $scheduleValueCreator;

    public function __construct(FieldValueCreator $fieldValueCreator, ScheduleValueCreator $scheduleValueCreator)
    {
        $this->fieldValueCreator = $fieldValueCreator;
        $this->scheduleValueCreator = $scheduleValueCreator;
    }

    public function convertToScheduleValue(DateTime $dateTime): ScheduleValue
    {
        $time = $this->fieldValueCreator->createTime(
            (int)$dateTime->format('H'),
            (int)$dateTime->format('i')
        );
        $date = $this->fieldValueCreator->createDate(
            (int)$dateTime->format('d'),
            (int)$dateTime->format('m'),
            (int)$dateTime->format('Y')
        );
        $dayOfWeek = $this->fieldValueCreator->createDayOfWeek(
            (int)$dateTime->format('N')
        );

        return $this->scheduleValueCreator->create($date, $time, $dayOfWeek);
    }
}
