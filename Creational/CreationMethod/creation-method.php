<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\Creational\CreationMethod;

class Number
{
    public function __construct(private int $value) {} // might be defined as private if needed

    public function previous(): static // creation method wraps a constructor call; name expresses intention
    {
        return new static($this->value - 1); // return self or its subclass instance
    }

    public function next(): static // creation methods bypass a limitation of a single constructor per class
    {
        return new static($this->value + 1); // return self or its subclass instance
    }

    public function getValue(): int
    {
        return $this->value;
    }
}

$number = new Number(1);

$previousNumber = $number->previous(); // using creation method to create a Number object
echo $previousNumber->getValue() . PHP_EOL;

$nextNumber = $number->next(); // using creation method to create a Number object
echo $nextNumber->getValue() . PHP_EOL;