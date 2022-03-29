# Schedule Expression

Инструмент для операций над графиком работ магазина.

## Установка

Добавить в `composer.json`:
```json
{
    "repositories": {
        "schedule-expression": {
            "type": "vcs",
            "url": "git@github.com:andrew-svirin/schedule-expression.git"
        }
    }
}
```
Выполнить:
`$ composer require andrew-svirin/schedule-expression:^1`

## Функции

- кодирование и декодирование выражения графика работ для организации
- редактирование графиков работ
- оценивание кодированного выражения графика работ для организации на статус работы и следующую дату работы

## Терминология

**Выражение** *(Expression)*
> Выражение графика работ для организации.  
> Состоит из списка графиков работ.  
> Пример: `H * 08.03.2021 *;W 10:00-17:30 * 1-5`

**График работ** *(Schedule)*
> Регулярно повторяющееся правило, описывающее единичный график работ.  
> Состоит из упорядоченных полей.  
> Пример: `H * 08.03.2021 *`

**Поле** *(Field)*
> Простое повторяющееся правило для определеннного временного значения (времени, даты, дня недели).  
> Пример: `*` или `H` или `10:00-17:30`

**Значение графика работ** *(ScheduleValue)*
> Композиция из значений полей, предназначенная для сравнения с графиком работ,
> либо для выражения следующего значения.

**Значение поля** *(FieldValue)*
> Простое значение которое используется для сравнения с полем
> либо для выражения следующего значения.

## Правило формирования графика работ

```
Type = W|D|H  
Time = mm:hh-mm:hh  
Date = j.n|j.n-j.n  
Day_of_Week = N|N-N
```

| Название                    | Приоритет | Type | Time | Date | Day_of_Week |
|-----------------------------|-----------|------|------|------|-------------|
| Еженедельный график         | 0         | W    | ?    | *    | ?           |
| Специальный график для даты | 1         | D    | ?    | ?    | *           |
| Праздники                   | 2         | H    | *    | ?    | *           |

## Применение

Больше примеров прменения можно найти в папке `tests\Functional`

### 1. Кодирование выражения графика работ для организации

Перед сохранением в БД график работ следует закодировать в строку.  
Ниже пример того, как добавить графики работ к общему выражению графика работ организации.

```php
    $sc = ScheduleExpression::create();
    // Выходные с 01.01.2021 по 07.01.2021
    $schedule1 = $sc->scheduleCreator()->createHoliday()
       ->setFromDate(1, 1, 2021)
       ->setToDate(7, 1, 2021);
    // Выходной 08.03.2021
    $schedule2 = $sc->scheduleCreator()->createHoliday()
       ->setDate(8, 3, 2021);
    // Рабочие дни с Понедельника по Пятницу с 10:00 по 17:30
    $schedule3 = $sc->scheduleCreator()->createDayOfWeek()
       ->setFromDayOfWeek(1)
       ->setToDayOfWeek(5)
       ->setFromTime(10)
       ->setToTime(17, 30);
    // Рабочий день в Субботу с 11:00 по 16:00
    $schedule4 = $sc->scheduleCreator()->createDayOfWeek()
       ->setDayOfWeek(6)
       ->setFromTime(11)
       ->setToTime(16);
    // Особый распорядок дня с 15.05.2021-18.06.2021 с 10:00 по 18:00
    $schedule5 = $sc->scheduleCreator()->createDayOfMonth()
       ->setFromDate(15, 5, 2021)
       ->setToDate(18, 6, 2021)
       ->setFromTime(10)
       ->setToTime(18);
    // Особый распорядок дня 20.06.2021 с 10:00 по 18:00
    $schedule6 = $sc->scheduleCreator()->createDayOfMonth()
       ->setDate(20, 6, 2021)
       ->setFromTime(10)
       ->setToTime(18);
    // Создаем выражение из графиков работ
    $expression = $sc->expressionCreator()->create()
        ->addSchedule($schedule1)
        ->addSchedule($schedule2)
        ->addSchedule($schedule3)
        ->addSchedule($schedule4)
        ->addSchedule($schedule5)
        ->addSchedule($schedule6);
    // Проверка и обработка ошибок выражения.
    $isValid = $sc->validator()->validateAndReturnResult($expression)->hasErrors();
    $encodedExpression = $sc->encoder()->encode($expression);
    // Результат:
    // H * 01.01.2021-07.01.2021 *;H * 08.03.2021 *;W 10:00-17:30 * 1-5;
    // W 11:00-16:00 * 6;D 10:00-18:00 15.05.2021-18.06.2021 *;
    // D 10:00-18:00 20.06.2021 *
```

### 2. Декодирование выражения графика работ для организации

Для редактирования и последующего сохранения выражения графика работ для организации необходимо выполнить декодирование.

```php
    $sc = ScheduleExpression::create();
    $encodedExpression = 'H * 01.01.2021-07.01.2021 *;H * 08.03.2021 *;W 10:00-17:30 * 1-5;';
    $expression = $sc->decoder()->decode($encodedExpression);
    // Редактируем выражение графика работ для организации
    /* @var \AndrewSvirin\ScheduleExpression\Domain\Schedule\HolidaySchedule $schedule1 */
    $schedule1 = $expression->getSchedules()[1];
    $schedule1->setToDate(9, 3, 2021);
    // Проверка и обработка ошибок выражения.
    $isValid = $sc->validator()->validateAndReturnResult($expression)->hasErrors();
    // Кодирование выражения графика работ для организации обратно в строку.
    $encodedExpression = $sc->encoder()->encode($expression);
    // Результат:
    // H * 01.01.2021-07.01.2021 *;H * 08.03.2021-09.03.2021 *;W 10:00-17:30 * 1-5;
```

### 3. Статус работы относительно выражения графика работ для организации

Для получения информации о том, работает организация в указанное время организация или нет.

```php
    $sc = ScheduleExpression::create();
    $encodedExpression = 'H * 01.01.2021-07.01.2021 *;H * 08.03.2021 *;W 10:00-17:30 * 1-5;';
    $expression = $sc->decoder()->decode($encodedExpression);
    $currentTime = new DateTime();
    $isDue = $sc->evaluator()->isDue($expression, $currentTime);
    // Результат:
    // true|false - рабочее ли сейчас время
```

### 4. Следующая дата работы относительно выражения графика работ для организации

Для получения информации о том когда у организации следующая рабочая дата и время.

```php
    $sc = ScheduleExpression::create();
    $encodedExpression = 'H * 01.01.2021-07.01.2021 *;H * 08.03.2021 *;W 10:00-17:30 * 1-5;';
    $expression = $sc->decoder()->decode($encodedExpression);
    $currentTime = new DateTime();
    $nextDueDateTime = $sc->evaluator()->resolveNextDueDateTime($expression, $currentTime);
    // Результат:
    // {DateTime} - следующая рабочая дата и время.
```
