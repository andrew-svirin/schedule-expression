<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Field\Validator;

use AndrewSvirin\ScheduleExpression\Components\ValidatorInterface\ValidationResultInterface;
use AndrewSvirin\ScheduleExpression\Components\ValidatorInterface\Validator;
use AndrewSvirin\ScheduleExpression\Domain\Field\TypeFieldInterface;

/**
 * Validator for field.
 * @internal
 */
class TypeFieldValidator implements Validator
{
    /**
     * @var string
     */
    private $incorrectError = 'Type is incorrect';
    /**
     * @var FieldValidationResultCreator
     */
    private $validationResultCreator;

    public function __construct(FieldValidationResultCreator $validationResultCreator)
    {
        $this->validationResultCreator = $validationResultCreator;
    }

    public function validateAndReturnResult(TypeFieldInterface $field): ValidationResultInterface
    {
        $validationResult = $this->validationResultCreator->create();

        if (!in_array($field->getType(), [
            TypeFieldInterface::WEEK,
            TypeFieldInterface::DAY,
            TypeFieldInterface::HOLIDAY,
        ])) {
            $validationResult->addError($this->incorrectError);
        }

        return $validationResult;
    }
}
