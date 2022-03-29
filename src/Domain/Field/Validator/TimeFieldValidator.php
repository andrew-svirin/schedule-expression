<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Field\Validator;

use AndrewSvirin\ScheduleExpression\Components\ValidatorInterface\ValidationResultInterface;
use AndrewSvirin\ScheduleExpression\Components\ValidatorInterface\Validator;
use AndrewSvirin\ScheduleExpression\Domain\Field\TimeFieldInterface;

/**
 * Validator for field.
 * @internal
 */
class TimeFieldValidator implements Validator
{
    /**
     * @var string
     */
    private $timeError = 'Time is incorrect';
    /**
     * @var string
     */
    private $rangeError = 'Start Time can no be greater than End Time';
    /**
     * @var FieldValidationResultCreator
     */
    private $validationResultCreator;

    public function __construct(FieldValidationResultCreator $validationResultCreator)
    {
        $this->validationResultCreator = $validationResultCreator;
    }

    public function validateAndReturnResult(TimeFieldInterface $field): ValidationResultInterface
    {
        $validationResult = $this->validationResultCreator->create();

        if ($field->isAny()) {
            return $validationResult;
        }

        if (!$this->isCorrectTime($field->getStartHour(), $field->getStartMinute()) ||
            !$this->isCorrectTime($field->getEndHour(), $field->getEndMinute())) {
            $validationResult->addError($this->timeError);
        }

        if ($this->isGreaterTime(
            $field->getStartHour(),
            $field->getStartMinute(),
            $field->getEndHour(),
            $field->getEndMinute()
        )) {
            $validationResult->addError($this->rangeError);
        }

        return $validationResult;
    }

    private function isCorrectTime(?int $hour, ?int $minute): bool
    {
        if ($hour < 0 || $hour > 23) {
            return false;
        }
        if ($minute < 0 || $minute > 59) {
            return false;
        }

        return true;
    }

    /**
     * Check that start time is greater than end time.
     */
    private function isGreaterTime(?int $startHour, ?int $startMinute, ?int $endHour, ?int $endMinute): bool
    {
        return $startHour > $endHour ||
            ($startHour === $endHour && $startMinute > $endMinute);
    }
}
