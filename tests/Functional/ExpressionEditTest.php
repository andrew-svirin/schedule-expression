<?php

namespace AndrewSvirin\ScheduleExpression\Tests\Functional;

use AndrewSvirin\ScheduleExpression\ScheduleExpression;
use PHPUnit\Framework\TestCase;

class ExpressionEditTest extends TestCase
{
    public function testExpressionAddSchedule()
    {
        $se = ScheduleExpression::create();
        $expression = $se->decoder()->decode('D 10:00-18:00 15.05.2021-18.06.2021 *');

        $schedule2 = $se->scheduleCreator()->createDayOfWeek()
            ->setDayOfWeek(1)
            ->setFromTime(10)
            ->setToTime(17, 30);

        $expression->addSchedule($schedule2);

        $encodedExpression = $se->encoder()->encode($expression);
        $this->assertEquals('D 10:00-18:00 15.05.2021-18.06.2021 *;W 10:00-17:30 * 1', $encodedExpression);
    }

    public function testExpressionUpdateSchedule()
    {
        $se = ScheduleExpression::create();
        $expression = $se->decoder()->decode('D 10:00-18:00 15.05.2021-18.06.2021 *;W 10:00-17:30 * 1');

        /* @var \AndrewSvirin\ScheduleExpression\Domain\Schedule\DayOfWeekSchedule $schedule2 */
        $schedule2 = $expression->getSchedules()[1];

        $schedule2->setDayOfWeek(2)
            ->setFromTime(10)
            ->setToTime(18, 30);

        $encodedExpression = $se->encoder()->encode($expression);
        $this->assertEquals('D 10:00-18:00 15.05.2021-18.06.2021 *;W 10:00-18:30 * 2', $encodedExpression);
    }

    public function testExpressionDeleteSchedule()
    {
        $se = ScheduleExpression::create();
        $expression = $se->decoder()->decode('D 10:00-18:00 15.05.2021-18.06.2021 *;W 10:00-18:30 * 2');

        $expression->deleteSchedule(1);

        $encodedExpression = $se->encoder()->encode($expression);
        $this->assertEquals('D 10:00-18:00 15.05.2021-18.06.2021 *', $encodedExpression);
    }
}
