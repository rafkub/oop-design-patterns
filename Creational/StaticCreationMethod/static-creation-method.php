<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\Creational\StaticCreationMethod;

use RuntimeException;

class Number
{
    public function __construct(private float $value) {} // might be defined as private if needed; accepts only float

    public static function createFromString(string $value): static // static creation method wraps a constructor call
    {
        if (!is_numeric(value: $value)) { // prevents passing values like '4.2a' which would be casted to 4.2
            throw new RuntimeException(message: "'$value' is not numeric and will not be converted");
        }
        return new static(value: (float) $value); // return self or its subclass instance
    }

    public function getValue(): float
    {
        return $this->value;
    }
}

$number = new Number(value: 42e-1); // not possible if a constructor defined as private
echo $number->getValue() . PHP_EOL;

$number = Number::createFromString(value: '42e-1'); // using static creation method as an alternative constructor
echo $number->getValue() . PHP_EOL;