<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Expression;

/**
 * Expression creator factory.
 * @internal
 */
class ExpressionCreator
{
    public function create(): Expression
    {
        return new Expression();
    }
}
