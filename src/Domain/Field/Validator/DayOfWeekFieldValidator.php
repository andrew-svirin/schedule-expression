<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Field\Validator;

use AndrewSvirin\ScheduleExpression\Components\ValidatorInterface\ValidationResultInterface;
use AndrewSvirin\ScheduleExpression\Components\ValidatorInterface\Validator;
use AndrewSvirin\ScheduleExpression\Domain\Field\DayOfWeekFieldInterface;

/**
 * Validator for field.
 * @internal
 */
class DayOfWeekFieldValidator implements Validator
{
    /**
     * @var string
     */
    private $dayOfWeekError = 'Day of Week is incorrect';
    /**
     * @var string
     */
    private $rangeError = 'Start Day of Week can no be greater than End Day of Week';
    /**
     * @var FieldValidationResultCreator
     */
    private $validationResultCreator;

    public function __construct(FieldValidationResultCreator $validationResultCreator)
    {
        $this->validationResultCreator = $validationResultCreator;
    }

    public function validateAndReturnResult(DayOfWeekFieldInterface $field): ValidationResultInterface
    {
        $validationResult = $this->validationResultCreator->create();

        if ($field->isAny()) {
            return $validationResult;
        }

        if (!$this->isCorrectDayOfWeek($field->getStartDayOfWeek()) ||
            !$this->isCorrectDayOfWeek($field->getEndDayOfWeek())) {
            $validationResult->addError($this->dayOfWeekError);
        }

        if ($this->isGreaterDayOfWeek(
            $field->getStartDayOfWeek(),
            $field->getEndDayOfWeek()
        )) {
            $validationResult->addError($this->rangeError);
        }

        return $validationResult;
    }

    private function isCorrectDayOfWeek(?int $dayOfWeek): bool
    {
        if ($dayOfWeek < 1 || $dayOfWeek > 7) {
            return false;
        }

        return true;
    }

    /**
     * Check that start day of week is greater than end day of week.
     */
    private function isGreaterDayOfWeek(?int $startDayOfWeek, ?int $endDayOfWeek): bool
    {
        return $startDayOfWeek > $endDayOfWeek;
    }
}
