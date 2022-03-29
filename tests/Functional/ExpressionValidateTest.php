<?php

namespace AndrewSvirin\ScheduleExpression\Tests\Functional;

use AndrewSvirin\ScheduleExpression\ScheduleExpression;
use PHPUnit\Framework\TestCase;

class ExpressionValidateTest extends TestCase
{
    /**
     * @dataProvider validateExpressionProvider
     */
    public function testValidateExpression(string $encodedExpression, bool $hasErrors, array $errors = [])
    {
        $se = ScheduleExpression::create();
        $expression = $se->decoder()->decode($encodedExpression);

        $validationResult = $se->validator()->validateAndReturnResult($expression);

        $this->assertEquals($hasErrors, $validationResult->hasErrors());
        $this->assertEquals($errors, $validationResult->getErrors());
    }

    public function validateExpressionProvider(): array
    {
        return [
            [
                'W 24:60-00:00 * 1',
                true,
                [
                    0 => [
                        'time' => [
                            'Time is incorrect',
                            'Start Time can no be greater than End Time',
                        ],
                    ]
                ]
            ],

            [
                'W 10:00-19:00 30.02.2021-28.02.2021 1',
                true,
                [
                    0 => [
                        'date' => [
                            'Date is incorrect',
                            'Start Date can no be greater than End Date',
                        ],
                    ]
                ]
            ],

            [
                'W 10:00-19:00 30.02.2021 1',
                true,
                [
                    0 => [
                        'date' => [
                            'Date is incorrect',
                        ],
                    ]
                ]
            ],

            [
                'W 10:00-19:00 * 8-7',
                true,
                [
                    0 => [
                        'day_of_week' => [
                            'Day of Week is incorrect',
                            'Start Day of Week can no be greater than End Day of Week',
                        ],
                    ]
                ]
            ],

            [
                'W 10:00-19:00 * 8',
                true,
                [
                    0 => [
                        'day_of_week' => [
                            'Day of Week is incorrect',
                        ],
                    ]
                ]
            ],
        ];
    }
}
