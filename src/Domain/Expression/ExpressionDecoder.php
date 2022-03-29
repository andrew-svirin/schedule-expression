<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Expression;

use AndrewSvirin\ScheduleExpression\Domain\Exception\ExpressionException;
use AndrewSvirin\ScheduleExpression\Domain\Schedule\ScheduleDecoder;

/**
 * Parser for expression.
 * @internal
 */
class ExpressionDecoder
{
    /**
     * @var ScheduleDecoder
     */
    private $scheduleDecoder;
    /**
     * @var ExpressionCreator
     */
    private $expressionCreator;

    public function __construct(ScheduleDecoder $scheduleDecoder, ExpressionCreator $expressionCreator)
    {
        $this->scheduleDecoder = $scheduleDecoder;
        $this->expressionCreator = $expressionCreator;
    }

    /**
     * @throws ExpressionException
     */
    public function decode(string $encodedExpression): Expression
    {
        $encodedSchedules = $this->explode($encodedExpression);

        $expression = $this->expressionCreator->create();

        foreach ($encodedSchedules as $encodedSchedule) {
            $schedule = $this->scheduleDecoder->decode($encodedSchedule);
            $expression->addSchedule($schedule);
        }

        return $expression;
    }

    /**
     * @return string[] Encoded schedules
     * @throws ExpressionException
     */
    private function explode(string $encodedExpression): array
    {
        $encodedSchedules = explode(ExpressionInterface::SCHEDULE_DELIMITER, $encodedExpression);
        if (!is_array($encodedSchedules)) {
            throw new ExpressionException('Can not explode encodedExpression');
        }

        return $encodedSchedules;
    }
}
