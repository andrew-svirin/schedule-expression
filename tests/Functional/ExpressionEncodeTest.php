<?php

namespace AndrewSvirin\ScheduleExpression\Tests\Functional;

use AndrewSvirin\ScheduleExpression\ScheduleExpression;
use PHPUnit\Framework\TestCase;

class ExpressionEncodeTest extends TestCase
{
    public function testEncodeDayOfWeekSingle()
    {
        $se = ScheduleExpression::create();
        $expression = $se->expressionCreator()->create();
        $schedule = $se->scheduleCreator()->createDayOfWeek()
            ->setDayOfWeek(1)
            ->setFromTime(10)
            ->setToTime(17, 30);
        $expression->addSchedule($schedule);
        $encodedExpression = $se->encoder()->encode($expression);
        $this->assertEquals('W 10:00-17:30 * 1', $encodedExpression);
    }

    public function testEncodeDayOfWeekRange()
    {
        $se = ScheduleExpression::create();
        $expression = $se->expressionCreator()->create();
        $schedule = $se->scheduleCreator()->createDayOfWeek()
            ->setFromDayOfWeek(1)
            ->setToDayOfWeek(5)
            ->setFromTime(10)
            ->setToTime(17, 30);
        $expression->addSchedule($schedule);
        $encodedExpression = $se->encoder()->encode($expression);
        $this->assertEquals('W 10:00-17:30 * 1-5', $encodedExpression);
    }

    public function testEncodeDayOfMonthSingle()
    {
        $se = ScheduleExpression::create();
        $expression = $se->expressionCreator()->create();
        $schedule = $se->scheduleCreator()->createDayOfMonth()
            ->setDate(1, 1, 2021)
            ->setFromTime(10)
            ->setToTime(18);
        $expression->addSchedule($schedule);
        $encodedExpression = $se->encoder()->encode($expression);
        $this->assertEquals('D 10:00-18:00 01.01.2021 *', $encodedExpression);
    }

    public function testEncodeDayOfMonthRange()
    {
        $se = ScheduleExpression::create();
        $expression = $se->expressionCreator()->create();
        $schedule = $se->scheduleCreator()->createDayOfMonth()
            ->setFromDate(15, 5, 2021)
            ->setToDate(18, 6, 2021)
            ->setFromTime(10)
            ->setToTime(18);
        $expression->addSchedule($schedule);
        $encodedExpression = $se->encoder()->encode($expression);
        $this->assertEquals('D 10:00-18:00 15.05.2021-18.06.2021 *', $encodedExpression);
    }

    public function testEncodeHolidaySingle()
    {
        $se = ScheduleExpression::create();
        $expression = $se->expressionCreator()->create();
        $schedule = $se->scheduleCreator()->createHoliday()
            ->setDate(8, 3, 2021);
        $expression->addSchedule($schedule);
        $encodedExpression = $se->encoder()->encode($expression);
        $this->assertEquals('H * 08.03.2021 *', $encodedExpression);
    }

    public function testEncodeHolidayRange()
    {
        $se = ScheduleExpression::create();
        $expression = $se->expressionCreator()->create();
        $schedule = $se->scheduleCreator()->createHoliday()
            ->setFromDate(1, 1, 2021)
            ->setToDate(7, 1, 2021);
        $expression->addSchedule($schedule);
        $encodedExpression = $se->encoder()->encode($expression);
        $this->assertEquals('H * 01.01.2021-07.01.2021 *', $encodedExpression);
    }

    public function testEncodeMultiple()
    {
        $se = ScheduleExpression::create();
        $expression = $se->expressionCreator()->create();
        $schedule1 = $se->scheduleCreator()->createHoliday()
            ->setFromDate(1, 1, 2021)
            ->setToDate(7, 1, 2021);
        $schedule2 = $se->scheduleCreator()->createHoliday()
            ->setDate(8, 3, 2021);
        $schedule3 = $se->scheduleCreator()->createDayOfWeek()
            ->setFromDayOfWeek(1)
            ->setToDayOfWeek(5)
            ->setFromTime(10)
            ->setToTime(17, 30);
        $schedule4 = $se->scheduleCreator()->createDayOfWeek()
            ->setDayOfWeek(6)
            ->setFromTime(11)
            ->setToTime(16);
        $schedule5 = $se->scheduleCreator()->createDayOfMonth()
            ->setFromDate(15, 5, 2021)
            ->setToDate(18, 6, 2021)
            ->setFromTime(10)
            ->setToTime(18);
        $schedule6 = $se->scheduleCreator()->createDayOfMonth()
            ->setDate(20, 6, 2021)
            ->setFromTime(10)
            ->setToTime(18);
        $expression->addSchedule($schedule1)
            ->addSchedule($schedule2)
            ->addSchedule($schedule3)
            ->addSchedule($schedule4)
            ->addSchedule($schedule5)
            ->addSchedule($schedule6);
        $encodedExpression = $se->encoder()->encode($expression);
        $this->assertEquals(
            'H * 01.01.2021-07.01.2021 *;H * 08.03.2021 *;W 10:00-17:30 * 1-5;W 11:00-16:00 * 6;D 10:00-18:00 15.05.2021-18.06.2021 *;D 10:00-18:00 20.06.2021 *',
            $encodedExpression
        );
    }
}
