<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Field;

/**
 * Public Implements field in schedule.
 * @internal
 */
interface FieldInterface
{
    const FIELD_ANY = '*';
    const FIELD_TIME_RANGE_FORMAT = '%02d:%02d-%02d:%02d';
    const FIELD_TIME_RANGE_PATTERN = '/^(?<start_hour>\d+):(?<start_minute>\d+)-' .
    '(?<end_hour>\d+):(?<end_minute>\d+)$/';
    const FIELD_DATE_SINGLE_FORMAT = '%02d.%02d.%02d';
    const FIELD_DATE_SINGLE_PATTERN = '/^(?<day>\d+).(?<month>\d+).(?<year>\d+)$/';
    const FIELD_DATE_RANGE_FORMAT = '%02d.%02d.%04d-%02d.%02d.%04d';
    const FIELD_DATE_RANGE_PATTERN = '/^(?<start_day>\d+).(?<start_month>\d+).(?<start_year>\d+)-' .
    '(?<end_day>\d+).(?<end_month>\d+).(?<end_year>\d+)$/';
    const FIELD_DAY_OF_WEEK_SINGLE_FORMAT = '%d';
    const FIELD_DAY_OF_WEEK_SINGLE_PATTERN = '/^(?<day_of_week>\d+)$/';
    const FIELD_DAY_OF_WEEK_RANGE_FORMAT = '%d-%d';
    const FIELD_DAY_OF_WEEK_RANGE_PATTERN = '/^(?<start_day_of_week>\d+)-(?<end_day_of_week>\d+)$/';
}
