<?php

namespace AndrewSvirin\ScheduleExpression\Tests\Functional;

use DateTime;
use AndrewSvirin\ScheduleExpression\ScheduleExpression;
use PHPUnit\Framework\TestCase;

class ExpressionEvaluateTest extends TestCase
{
    /**
     * @dataProvider dueExpressionProvider
     */
    public function testDueExpression($encodedExpression, $nowDatetime, $result)
    {
        $se = ScheduleExpression::create();
        $expression = $se->decoder()->decode($encodedExpression);
        $now = DateTime::createFromFormat('Y-m-d H:i', $nowDatetime);
        $this->assertEquals($result,  $se->evaluator()->isDue($expression, $now));
    }

    public function dueExpressionProvider(): array
    {
        return [
            ['W 10:30-17:30 * 1', '2021-01-01 11:00', false], // N = 5
            ['W 10:30-17:30 * 1', '2021-01-04 11:00', true], // N = 1
            ['W 10:30-17:30 * 1;H * 04.01.2021 *', '2021-01-04 11:00', false],
            ['W 10:30-17:30 * 1;H * 01.01.2021-04.01.2021 *', '2021-01-04 11:00', false],
            ['W 10:30-17:30 * 1;D 10:00-18:00 01.01.2021 *', '2021-01-01 11:00', true],
            ['W 10:30-17:30 * 1;D 12:00-18:00 04.01.2021 *', '2021-01-04 11:00', false],
            ['W 10:30-17:30 * 1;D 10:00-18:00 28.12.2020-01.01.2021 *', '2021-01-01 11:00', true],
            ['W 10:30-17:30 * 1;D 12:00-18:00 01.01.2021-04.01.2021 *', '2021-01-04 11:00', false],
            ['W 10:30-17:30 * 1;D 10:00-18:00 01.01.2021 *;H * 04.01.2021 *', '2021-01-04 11:00', false],
        ];
    }

    /**
     * @dataProvider nextDueDateExpressionProvider
     */
    public function testNextDueDateTimeExpression($encodedExpression, $nowDatetime, $result)
    {
        $se = ScheduleExpression::create();
        $expression = $se->decoder()->decode($encodedExpression);
        $now = DateTime::createFromFormat('Y-m-d H:i', $nowDatetime);
        $nextDate = $se->evaluator()->resolveNextDueDateTime($expression, $now)->format('Y-m-d H:i');
        $this->assertEquals($result, $nextDate);
    }

    public function nextDueDateExpressionProvider(): array
    {
        return [
            ['W 10:30-17:30 * 1', '2021-01-01 11:00', '2021-01-04 10:30'], // N = 5
            ['W 10:30-17:30 * 1', '2021-01-04 11:00', '2021-01-11 10:30'], // N = 1
            ['W 10:30-17:30 * 1;H * 04.01.2021 *', '2021-01-04 11:00', '2021-01-11 10:30'],
            ['W 10:30-17:30 * 1;H * 01.01.2021-04.01.2021 *', '2021-01-04 11:00', '2021-01-11 10:30'],
            ['W 10:30-17:30 * 1;D 10:00-18:00 01.01.2021 *', '2021-01-01 11:00', '2021-01-04 10:30'],
            ['W 10:30-17:30 * 1;D 12:00-18:00 04.01.2021 *', '2021-01-04 11:00', '2021-01-04 12:00'],
            ['W 10:30-17:30 * 1;D 10:00-18:00 28.12.2020-01.01.2021 *', '2021-01-01 11:00', '2021-01-04 10:30'],
            ['W 10:30-17:30 * 1;D 12:00-18:00 01.01.2021-04.01.2021 *', '2021-01-04 11:00', '2021-01-04 12:00'],
            [
                'W 10:30-17:30 * 1;D 10:00-18:00 01.01.2021 *;H * 04.01.2021 *;H * 10.01-2021-11.01.2021 *',
                '2021-01-04 11:00',
                '2021-01-18 10:30',
            ],
        ];
    }
}
