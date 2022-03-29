<?php

namespace AndrewSvirin\ScheduleExpression\Domain\Field;

/**
 * Express time field.
 * @internal
 */
class TypeField extends Field implements TypeFieldInterface
{
    /**
     * @var string
     */
    private $type;

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }
}
