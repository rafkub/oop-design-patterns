<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\Creational\WithoutStaticCreationMethod;

use RuntimeException;

class Number
{
    public function __construct(private float $value) {}

    public function getValue(): float
    {
        return $this->value;
    }
}

$value = 42e-1;
$number = new Number(value: $value);
echo $number->getValue() . PHP_EOL;

$value = '42e-1';
// Creating a Number object from string requires some validation and casting:
if (!is_numeric(value: $value)) { // prevents passing values like '4.2a' which would be casted to 4.2
    throw new RuntimeException(message: "'$value' is not numeric and will not be converted");
}
$number = new Number(value: (float) $value);
echo $number->getValue() . PHP_EOL;