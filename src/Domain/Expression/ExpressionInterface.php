<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Expression;

use AndrewSvirin\ScheduleExpression\Domain\Schedule\ScheduleInterface;

/**
 * Public Express schedules.
 * @internal
 */
interface ExpressionInterface
{
    const SCHEDULE_DELIMITER = ';';

    /**
     * @return ScheduleInterface[]
     */
    public function getSchedules(): array;
}
