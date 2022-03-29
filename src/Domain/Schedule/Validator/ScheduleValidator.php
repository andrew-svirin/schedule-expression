<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Schedule\Validator;

use AndrewSvirin\ScheduleExpression\Components\ValidatorInterface\ValidationResultInterface;
use AndrewSvirin\ScheduleExpression\Components\ValidatorInterface\Validator;
use AndrewSvirin\ScheduleExpression\Domain\Field\Validator\DateFieldValidator;
use AndrewSvirin\ScheduleExpression\Domain\Field\Validator\DayOfWeekFieldValidator;
use AndrewSvirin\ScheduleExpression\Domain\Field\Validator\TimeFieldValidator;
use AndrewSvirin\ScheduleExpression\Domain\Field\Validator\TypeFieldValidator;
use AndrewSvirin\ScheduleExpression\Domain\Schedule\ScheduleInterface;

/**
 * Validator for schedule.
 * @internal
 */
class ScheduleValidator implements Validator
{
    /**
     * @var ScheduleValidationResultCreator
     */
    private $validationResultCreator;
    /**
     * @var TypeFieldValidator
     */
    private $typeFieldValidator;
    /**
     * @var TimeFieldValidator
     */
    private $timeFieldValidator;
    /**
     * @var DateFieldValidator
     */
    private $dateFieldValidator;
    /**
     * @var DayOfWeekFieldValidator
     */
    private $dayOfWeekFieldValidator;

    public function __construct(
        ScheduleValidationResultCreator $validationResultCreator,
        TypeFieldValidator $typeFieldValidator,
        TimeFieldValidator $timeFieldValidator,
        DateFieldValidator $dateFieldValidator,
        DayOfWeekFieldValidator $dayOfWeekFieldValidator
    ) {
        $this->validationResultCreator = $validationResultCreator;
        $this->typeFieldValidator = $typeFieldValidator;
        $this->timeFieldValidator = $timeFieldValidator;
        $this->dateFieldValidator = $dateFieldValidator;
        $this->dayOfWeekFieldValidator = $dayOfWeekFieldValidator;
    }

    public function validateAndReturnResult(ScheduleInterface $schedule): ValidationResultInterface
    {
        $validationResult = $this->validationResultCreator->create();

        $fieldValidationResult = $this->typeFieldValidator->validateAndReturnResult($schedule->getTypeField());
        if ($fieldValidationResult->hasErrors()) {
            $validationResult->addFieldErrors('type', $fieldValidationResult->getErrors());
        }

        $fieldValidationResult = $this->timeFieldValidator->validateAndReturnResult($schedule->getTimeField());
        if ($fieldValidationResult->hasErrors()) {
            $validationResult->addFieldErrors('time', $fieldValidationResult->getErrors());
        }

        $fieldValidationResult = $this->dateFieldValidator->validateAndReturnResult($schedule->getDateField());
        if ($fieldValidationResult->hasErrors()) {
            $validationResult->addFieldErrors('date', $fieldValidationResult->getErrors());
        }

        $fieldValidationResult = $this->dayOfWeekFieldValidator->validateAndReturnResult(
            $schedule->getDayOfWeekField()
        );
        if ($fieldValidationResult->hasErrors()) {
            $validationResult->addFieldErrors('day_of_week', $fieldValidationResult->getErrors());
        }

        return $validationResult;
    }
}
