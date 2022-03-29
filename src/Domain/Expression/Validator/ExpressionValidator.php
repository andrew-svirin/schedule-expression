<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Expression\Validator;

use AndrewSvirin\ScheduleExpression\Components\ValidatorInterface\ValidationResultInterface;
use AndrewSvirin\ScheduleExpression\Components\ValidatorInterface\Validator;
use AndrewSvirin\ScheduleExpression\Domain\Expression\ExpressionInterface;
use AndrewSvirin\ScheduleExpression\Domain\Schedule\Validator\ScheduleValidator;

/**
 * Validator for expression.
 * @internal
 */
class ExpressionValidator implements Validator
{
    /**
     * @var ExpressionValidationResultCreator
     */
    private $validationResultCreator;
    /**
     * @var ScheduleValidator
     */
    private $scheduleValidator;

    public function __construct(
        ExpressionValidationResultCreator $validationResultCreator,
        ScheduleValidator $scheduleValidator
    ) {
        $this->validationResultCreator = $validationResultCreator;
        $this->scheduleValidator = $scheduleValidator;
    }

    public function validateAndReturnResult(ExpressionInterface $expression): ValidationResultInterface
    {
        $validationResult = $this->validationResultCreator->create();
        foreach ($expression->getSchedules() as $id => $schedule) {
            $scheduleValidationResult = $this->scheduleValidator->validateAndReturnResult($schedule);
            if ($scheduleValidationResult->hasErrors()) {
                $validationResult->addScheduleErrors($id, $scheduleValidationResult->getErrors());
            }
        }

        return $validationResult;
    }
}
