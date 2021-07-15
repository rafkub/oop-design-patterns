<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\Creational\WithoutCreationMethod;

class Number
{
    public function __construct(private int $value) {}

    public function getValue(): int
    {
        return $this->value;
    }
}

$number = new Number(1);

$previousNumber = new Number($number->getValue() - 1); // manual creation of a Number object using standard constructor
echo $previousNumber->getValue() . PHP_EOL;

$nextNumber = new Number($number->getValue() + 1); // manual creation of a Number object using standard constructor
echo $nextNumber->getValue() . PHP_EOL;