<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Field\Validator;

use AndrewSvirin\ScheduleExpression\Components\ValidatorInterface\ValidationResultInterface;
use AndrewSvirin\ScheduleExpression\Components\ValidatorInterface\Validator;
use AndrewSvirin\ScheduleExpression\Domain\Field\DateFieldInterface;

/**
 * Validator for field.
 * @internal
 */
class DateFieldValidator implements Validator
{
    /**
     * @var string
     */
    private $dateError = 'Date is incorrect';
    /**
     * @var string
     */
    private $rangeError = 'Start Date can no be greater than End Date';
    /**
     * @var FieldValidationResultCreator
     */
    private $validationResultCreator;

    public function __construct(FieldValidationResultCreator $validationResultCreator)
    {
        $this->validationResultCreator = $validationResultCreator;
    }

    public function validateAndReturnResult(DateFieldInterface $field): ValidationResultInterface
    {
        $validationResult = $this->validationResultCreator->create();

        if ($field->isAny()) {
            return $validationResult;
        }

        if (!$this->isCorrectDate($field->getStartDay(), $field->getStartMonth(), $field->getStartYear()) ||
            !$this->isCorrectDate($field->getEndDay(), $field->getEndMonth(), $field->getEndYear())) {
            $validationResult->addError($this->dateError);
        }

        if ($this->isGreaterDate(
            $field->getStartDay(),
            $field->getStartMonth(),
            $field->getStartYear(),
            $field->getEndDay(),
            $field->getEndMonth(),
            $field->getEndYear()
        )) {
            $validationResult->addError($this->rangeError);
        }

        return $validationResult;
    }

    private function isCorrectDate(?int $day, ?int $month, ?int $year): bool
    {
        return checkdate($month ?? 0, $day ?? 0, $year ?? 0);
    }

    /**
     * Check that start date is greater than end date.
     */
    private function isGreaterDate(
        ?int $startDay,
        ?int $startMonth,
        ?int $startYear,
        ?int $endDay,
        ?int $endMonth,
        ?int $endYear
    ): bool {
        return $startYear > $endYear ||
            ($startYear === $endYear && $startMonth > $endMonth) ||
            ($startYear === $endYear && $startMonth === $endMonth && $startDay > $endDay);
    }
}
