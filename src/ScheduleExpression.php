<?php

namespace AndrewSvirin\ScheduleExpression;

use AndrewSvirin\ScheduleExpression\Domain\Expression\ExpressionCreator;
use AndrewSvirin\ScheduleExpression\Domain\Expression\ExpressionDecoder;
use AndrewSvirin\ScheduleExpression\Domain\Expression\ExpressionEncoder;
use AndrewSvirin\ScheduleExpression\Domain\Expression\ExpressionEvaluator;
use AndrewSvirin\ScheduleExpression\Domain\Expression\Validator\ExpressionValidator;
use AndrewSvirin\ScheduleExpression\Domain\Schedule\ScheduleCreator;
use AndrewSvirin\ScheduleExpression\Components\Service\ServiceLocator;

/**
 * Facade to work with schedule expression.
 */
class ScheduleExpression
{
    /**
     * @var ServiceLocator
     */
    private $serviceLocator;

    /**
     * Instantiate by method self::create()
     */
    private function __construct(ServiceLocator $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * Use encoder to build and encode expression.
     */
    public function encoder(): ExpressionEncoder
    {
        return $this->serviceLocator->get(ExpressionEncoder::class);
    }

    /**
     * Use decoder to resolve expression.
     */
    public function decoder(): ExpressionDecoder
    {
        return $this->serviceLocator->get(ExpressionDecoder::class);
    }

    /**
     * Use decoder to resolve expression.
     */
    public function evaluator(): ExpressionEvaluator
    {
        return $this->serviceLocator->get(ExpressionEvaluator::class);
    }

    /**
     * Use validator to validate expression.
     */
    public function validator(): ExpressionValidator
    {
        return $this->serviceLocator->get(ExpressionValidator::class);
    }

    /**
     * Use ExpressionCreator for create expression and add to encoder.
     */
    public function expressionCreator(): ExpressionCreator
    {
        return $this->serviceLocator->get(ExpressionCreator::class);
    }

    /**
     * Use scheduleCreator for create schedules and add to expression.
     */
    public function scheduleCreator(): ScheduleCreator
    {
        return $this->serviceLocator->get(ScheduleCreator::class);
    }

    /**
     * Factory for service.
     */
    public static function create(): self
    {
        return new self(new ServiceLocator());
    }
}
