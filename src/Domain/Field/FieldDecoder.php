<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Field;

use AndrewSvirin\ScheduleExpression\Domain\Exception\ExpressionException;

/**
 * Field decoder.
 * @internal
 */
class FieldDecoder
{
    /**
     * @var FieldCreator
     */
    private $fieldCreator;

    public function __construct(FieldCreator $fieldCreator)
    {
        $this->fieldCreator = $fieldCreator;
    }

    public function decodeTypeField(string $encodedField): TypeField
    {
        $field = $this->fieldCreator->createTypeField();
        $field->setType($encodedField);

        return $field;
    }

    /**
     * @throws ExpressionException
     */
    public function decodeTimeField(string $encodedField): TimeField
    {
        $field = $this->fieldCreator->createTimeField();
        if (FieldInterface::FIELD_ANY === $encodedField) {
            return $field;
        } elseif (preg_match(FieldInterface::FIELD_TIME_RANGE_PATTERN, $encodedField, $values)) {
            $field->setStartHour((int)$values['start_hour']);
            $field->setStartMinute((int)$values['start_minute']);
            $field->setEndHour((int)$values['end_hour']);
            $field->setEndMinute((int)$values['end_minute']);
            return $field;
        } else {
            throw new ExpressionException('Time Field was not decoded');
        }
    }

    /**
     * @throws ExpressionException
     */
    public function decodeDateField(string $encodedField): DateField
    {
        $field = $this->fieldCreator->createDateField();
        if (FieldInterface::FIELD_ANY === $encodedField) {
            return $field;
        } elseif (preg_match(FieldInterface::FIELD_DATE_RANGE_PATTERN, $encodedField, $values)) {
            $field->setStartDay((int)$values['start_day']);
            $field->setStartMonth((int)$values['start_month']);
            $field->setStartYear((int)$values['start_year']);
            $field->setEndDay((int)$values['end_day']);
            $field->setEndMonth((int)$values['end_month']);
            $field->setEndYear((int)$values['end_year']);
            return $field;
        } elseif (preg_match(FieldInterface::FIELD_DATE_SINGLE_PATTERN, $encodedField, $values)) {
            $field->setStartDay((int)$values['day']);
            $field->setStartMonth((int)$values['month']);
            $field->setStartYear((int)$values['year']);
            $field->setEndDay((int)$values['day']);
            $field->setEndMonth((int)$values['month']);
            $field->setEndYear((int)$values['year']);
            return $field;
        } else {
            throw new ExpressionException('Date Field was not decoded');
        }
    }

    /**
     * @throws ExpressionException
     */
    public function decodeDayOfWeekField(string $encodedField): DayOfWeekField
    {
        $field = $this->fieldCreator->createDayOfWeekField();
        if (FieldInterface::FIELD_ANY === $encodedField) {
            return $field;
        } elseif (preg_match(FieldInterface::FIELD_DAY_OF_WEEK_RANGE_PATTERN, $encodedField, $values)) {
            $field->setStartDayOfWeek((int)$values['start_day_of_week']);
            $field->setEndDayOfWeek((int)$values['end_day_of_week']);
        } elseif (preg_match(FieldInterface::FIELD_DAY_OF_WEEK_SINGLE_PATTERN, $encodedField, $values)) {
            $field->setStartDayOfWeek((int)$values['day_of_week']);
            $field->setEndDayOfWeek((int)$values['day_of_week']);
        } else {
            throw new ExpressionException('Day Of Week Field was not decoded');
        }

        return $field;
    }
}
