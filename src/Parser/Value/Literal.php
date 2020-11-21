<?php

declare(strict_types = 1);

namespace Graphpinator\Parser\Value;

final class Literal implements \Graphpinator\Parser\Value\Value
{
    use \Nette\SmartObject;

    private string|int|float|bool|null|array|\stdClass $value;

    public function __construct(string|int|float|bool|null|array|\stdClass $value)
    {
        $this->value = $value;
    }

    public function getRawValue() : string|int|float|bool|null|array|\stdClass
    {
        return $this->value;
    }

    public function applyVariables(\Graphpinator\Resolver\VariableValueSet $variables) : Value
    {
        return $this;
    }

    public function isSame(Value $compare) : bool
    {
        return $compare instanceof self
            && $this->value === $compare->getRawValue();
    }
}
