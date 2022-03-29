<?php

namespace AndrewSvirin\ScheduleExpression\Tests\Functional;

use AndrewSvirin\ScheduleExpression\ScheduleExpression;
use PHPUnit\Framework\TestCase;

class ExpressionDecodeTest extends TestCase
{
    public function testDecodeDayOfWeekSingle()
    {
        $expression = ScheduleExpression::create()->decoder()->decode('W 10:00-17:30 * 1');

        $schedule = $expression->getSchedules()[0];

        $this->assertEquals('W', $schedule->getTypeField()->getType());
        $this->assertEquals(10, $schedule->getTimeField()->getStartHour());
        $this->assertEquals(null, $schedule->getTimeField()->getStartMinute());
        $this->assertEquals(17, $schedule->getTimeField()->getEndHour());
        $this->assertEquals(30, $schedule->getTimeField()->getEndMinute());
        $this->assertEquals(1, $schedule->getDayOfWeekField()->getStartDayOfWeek());
    }

    public function testDecodeDayOfWeekRange()
    {
        $expression = ScheduleExpression::create()->decoder()->decode('W 10:00-17:30 * 1-5');

        $schedule = $expression->getSchedules()[0];

        $this->assertEquals('W', $schedule->getTypeField()->getType());
        $this->assertEquals(10, $schedule->getTimeField()->getStartHour());
        $this->assertEquals(null, $schedule->getTimeField()->getStartMinute());
        $this->assertEquals(17, $schedule->getTimeField()->getEndHour());
        $this->assertEquals(30, $schedule->getTimeField()->getEndMinute());
        $this->assertEquals(1, $schedule->getDayOfWeekField()->getStartDayOfWeek());
        $this->assertEquals(5, $schedule->getDayOfWeekField()->getEndDayOfWeek());
    }

    public function testDecodeDayOfMonthSingle()
    {
        $expression = ScheduleExpression::create()->decoder()->decode('D 10:00-18:00 01.01.2021 *');

        $schedule = $expression->getSchedules()[0];

        $this->assertEquals('D', $schedule->getTypeField()->getType());
        $this->assertEquals(10, $schedule->getTimeField()->getStartHour());
        $this->assertEquals(null, $schedule->getTimeField()->getStartMinute());
        $this->assertEquals(18, $schedule->getTimeField()->getEndHour());
        $this->assertEquals(null, $schedule->getTimeField()->getEndMinute());
        $this->assertEquals(1, $schedule->getDateField()->getStartDay());
        $this->assertEquals(1, $schedule->getDateField()->getStartMonth());
        $this->assertEquals(2021, $schedule->getDateField()->getStartYear());
    }

    public function testDecodeDayOfMonthRange()
    {
        $expression = ScheduleExpression::create()->decoder()->decode('D 10:00-18:00 15.05.2021-18.06.2021 *');

        $schedule = $expression->getSchedules()[0];

        $this->assertEquals('D', $schedule->getTypeField()->getType());
        $this->assertEquals(10, $schedule->getTimeField()->getStartHour());
        $this->assertEquals(null, $schedule->getTimeField()->getStartMinute());
        $this->assertEquals(18, $schedule->getTimeField()->getEndHour());
        $this->assertEquals(null, $schedule->getTimeField()->getEndMinute());
        $this->assertEquals(15, $schedule->getDateField()->getStartDay());
        $this->assertEquals(5, $schedule->getDateField()->getStartMonth());
        $this->assertEquals(2021, $schedule->getDateField()->getStartYear());
        $this->assertEquals(18, $schedule->getDateField()->getEndDay());
        $this->assertEquals(6, $schedule->getDateField()->getEndMonth());
        $this->assertEquals(2021, $schedule->getDateField()->getEndYear());
    }

    public function testDecodeHolidaySingle()
    {
        $expression = ScheduleExpression::create()->decoder()->decode('H * 08.03.2021 *');

        $schedule = $expression->getSchedules()[0];

        $this->assertEquals('H', $schedule->getTypeField()->getType());
        $this->assertEquals(8, $schedule->getDateField()->getStartDay());
        $this->assertEquals(3, $schedule->getDateField()->getStartMonth());
        $this->assertEquals(2021, $schedule->getDateField()->getStartYear());
    }

    public function testDecodeHolidayRange()
    {
        $expression = ScheduleExpression::create()->decoder()->decode('H * 01.01.2021-07.01.2021 *');

        $schedule = $expression->getSchedules()[0];

        $this->assertEquals('H', $schedule->getTypeField()->getType());
        $this->assertEquals(1, $schedule->getDateField()->getStartDay());
        $this->assertEquals(1, $schedule->getDateField()->getStartMonth());
        $this->assertEquals(2021, $schedule->getDateField()->getStartYear());
        $this->assertEquals(7, $schedule->getDateField()->getEndDay());
        $this->assertEquals(1, $schedule->getDateField()->getEndMonth());
        $this->assertEquals(2021, $schedule->getDateField()->getEndYear());
    }

    public function testDecodeMultiple()
    {
        $expression = ScheduleExpression::create()->decoder()->decode('H * 01.01.2021-07.01.2021 *;' .
            'H * 08.03.2021 *;' .
            'W 10:00-17:30 * 1-5;' .
            'W 11:00-16:00 * 6;' .
            'D 10:00-18:00 15.05.2021-18.06.2021 *;' .
            'D 10:00-18:00 20.06.2021 *');

        $this->assertCount(6, $expression->getSchedules());

        $schedule1 = $expression->getSchedules()[0];

        $this->assertEquals('H', $schedule1->getTypeField()->getType());
        $this->assertEquals(1, $schedule1->getDateField()->getStartDay());
        $this->assertEquals(1, $schedule1->getDateField()->getStartMonth());
        $this->assertEquals(2021, $schedule1->getDateField()->getStartYear());
        $this->assertEquals(7, $schedule1->getDateField()->getEndDay());
        $this->assertEquals(1, $schedule1->getDateField()->getEndMonth());
        $this->assertEquals(2021, $schedule1->getDateField()->getEndYear());

        $schedule2 = $expression->getSchedules()[1];

        $this->assertEquals('H', $schedule2->getTypeField()->getType());
        $this->assertEquals(8, $schedule2->getDateField()->getStartDay());
        $this->assertEquals(3, $schedule2->getDateField()->getStartMonth());
        $this->assertEquals(2021, $schedule2->getDateField()->getStartYear());

        $schedule3 = $expression->getSchedules()[2];

        $this->assertEquals('W', $schedule3->getTypeField()->getType());
        $this->assertEquals(10, $schedule3->getTimeField()->getStartHour());
        $this->assertEquals(null, $schedule3->getTimeField()->getStartMinute());
        $this->assertEquals(17, $schedule3->getTimeField()->getEndHour());
        $this->assertEquals(30, $schedule3->getTimeField()->getEndMinute());
        $this->assertEquals(1, $schedule3->getDayOfWeekField()->getStartDayOfWeek());
        $this->assertEquals(5, $schedule3->getDayOfWeekField()->getEndDayOfWeek());

        $schedule4 = $expression->getSchedules()[3];

        $this->assertEquals('W', $schedule4->getTypeField()->getType());
        $this->assertEquals(11, $schedule4->getTimeField()->getStartHour());
        $this->assertEquals(null, $schedule4->getTimeField()->getStartMinute());
        $this->assertEquals(16, $schedule4->getTimeField()->getEndHour());
        $this->assertEquals(null, $schedule4->getTimeField()->getEndMinute());
        $this->assertEquals(6, $schedule4->getDayOfWeekField()->getStartDayOfWeek());

        $schedule5 = $expression->getSchedules()[4];

        $this->assertEquals('D', $schedule5->getTypeField()->getType());
        $this->assertEquals(10, $schedule5->getTimeField()->getStartHour());
        $this->assertEquals(null, $schedule5->getTimeField()->getStartMinute());
        $this->assertEquals(18, $schedule5->getTimeField()->getEndHour());
        $this->assertEquals(null, $schedule5->getTimeField()->getEndMinute());
        $this->assertEquals(15, $schedule5->getDateField()->getStartDay());
        $this->assertEquals(5, $schedule5->getDateField()->getStartMonth());
        $this->assertEquals(2021, $schedule5->getDateField()->getStartYear());
        $this->assertEquals(18, $schedule5->getDateField()->getEndDay());
        $this->assertEquals(6, $schedule5->getDateField()->getEndMonth());
        $this->assertEquals(2021, $schedule5->getDateField()->getEndYear());

        $schedule6 = $expression->getSchedules()[5];

        $this->assertEquals('D', $schedule6->getTypeField()->getType());
        $this->assertEquals(10, $schedule6->getTimeField()->getStartHour());
        $this->assertEquals(null, $schedule6->getTimeField()->getStartMinute());
        $this->assertEquals(18, $schedule6->getTimeField()->getEndHour());
        $this->assertEquals(null, $schedule6->getTimeField()->getEndMinute());
        $this->assertEquals(20, $schedule6->getDateField()->getStartDay());
        $this->assertEquals(6, $schedule6->getDateField()->getStartMonth());
        $this->assertEquals(2021, $schedule6->getDateField()->getStartYear());
    }
}
