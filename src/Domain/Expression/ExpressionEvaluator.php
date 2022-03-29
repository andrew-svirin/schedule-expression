<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Expression;

use DateTime;
use AndrewSvirin\ScheduleExpression\Domain\Exception\ExpressionException;
use AndrewSvirin\ScheduleExpression\Domain\Schedule\ScheduleEvaluator;
use AndrewSvirin\ScheduleExpression\Domain\Schedule\ScheduleInterface;

/**
 * Expression evaluator.
 * @internal
 */
class ExpressionEvaluator
{
    /**
     * @var ScheduleEvaluator
     */
    private $scheduleEvaluator;

    public function __construct(ScheduleEvaluator $scheduleEvaluator)
    {
        $this->scheduleEvaluator = $scheduleEvaluator;
    }

    /**
     * Determinate that expression is due for the time.
     * 1. Go over all holiday schedules and check is due, if yes - then return false.
     * 2. Ignore timeField and Go over all day schedules and check is due, if yes - then calculate with time and
     * return true or false by due.
     * 3. Go over all week schedules and check is due, if yes - then return true.
     * @throws ExpressionException
     */
    public function isDue(Expression $expression, DateTime $now): bool
    {
        foreach ($expression->filterHolidaySchedules() as $schedule) {
            if ($this->scheduleEvaluator->isDue($schedule, $now)) {
                return false;
            }
        }

        foreach ($expression->filterDayOfMonthSchedules() as $schedule) {
            if (!$this->isDueToday($schedule, $now)) {
                continue;
            }

            return $this->scheduleEvaluator->isDue($schedule, $now);
        }

        foreach ($expression->filterDayOfWeekSchedules() as $schedule) {
            if ($this->scheduleEvaluator->isDue($schedule, $now)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determinate next run datetime by expression.
     * Determinate `now`.
     * 1. If is holiday, then take next day after holiday schedule for `now`.
     * 2. Loop over holidays and if is due, then take next day for now.
     * 3. Ignore timeField and check is due day. If yes - then take timeField to know if work day not started,
     *  if not, then use current day, else use next day for now.
     * Determinate `next day`
     * 4. If now is work day, then take a time, else take next day.
     * @throws ExpressionException
     */
    public function resolveNextDueDateTime(Expression $expression, DateTime $now): DateTime
    {
        return $this->recursiveResolveNextDueDateTime($expression, $now, 0);
    }

    /**
     * Resolve next run datetime by expression with recursion.
     * @throws ExpressionException
     */
    private function recursiveResolveNextDueDateTime(
        Expression $expression,
        DateTime $now,
        int $loopIteration
    ): DateTime {
        if (100 < $loopIteration) {
            // Can be improved loop when use single schedule expression for holidays.
            throw new ExpressionException('Loop limit for expression is over 100');
        }

        foreach ($expression->filterHolidaySchedules() as $schedule) {
            if ($this->scheduleEvaluator->isDue($schedule, $now)) {
                $newNow = $this->scheduleEvaluator->resolveLastDateOfHoliday($schedule);
                $newNow->setTime(0, 0)->modify('+1 day');
                $loopIteration++;
                return $this->recursiveResolveNextDueDateTime($expression, $newNow, $loopIteration);
            }
        }

        foreach ($expression->filterDayOfMonthSchedules() as $schedule) {
            $nextDueDateTime = $this->resolveTodayDueDateTime($schedule, $now);
            if (null !== $nextDueDateTime) {
                return $nextDueDateTime;
            }
        }

        $dayOfWeekSchedules = $expression->filterDayOfWeekSchedules();
        if (empty($dayOfWeekSchedules)) {
            throw new ExpressionException('Schedule for week not present');
        }
        foreach ($dayOfWeekSchedules as $schedule) {
            $nextDueDateTime = $this->resolveTodayDueDateTime($schedule, $now);
            if (null !== $nextDueDateTime) {
                return $nextDueDateTime;
            }
        }

        $now->setTime(0, 0)->modify('+1 day');
        $loopIteration++;
        return $this->recursiveResolveNextDueDateTime($expression, $now, $loopIteration);
    }

    /**
     * @throws ExpressionException
     */
    private function isDueToday(ScheduleInterface $schedule, DateTime $now): bool
    {
        $scheduleIgnoringTimeField = $this->scheduleEvaluator->resolveScheduleIgnoringTime($schedule);

        return $this->scheduleEvaluator->isDue($scheduleIgnoringTimeField, $now);
    }

    /**
     * @throws ExpressionException
     */
    private function resolveTodayDueDateTime(ScheduleInterface $schedule, DateTime $now): ?DateTime
    {
        if (!$this->isDueToday($schedule, $now)) {
            return null;
        }

        if (!$this->scheduleEvaluator->isNowBeforeScheduleTime($schedule, $now)) {
            return null;
        }

        return $this->scheduleEvaluator->resolveScheduleStartDateTime($schedule, $now);
    }
}
