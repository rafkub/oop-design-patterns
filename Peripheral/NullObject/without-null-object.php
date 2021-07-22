<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\Peripheral\WithoutNullObject;

class Dog
{
    public function makeSound(): string
    {
        return "Woof!";
    }
}

$animal = new Dog();
echo $animal->makeSound() . PHP_EOL;

$animal = null;
// echo $animal->makeSound() . PHP_EOL; // would cause 'Fatal error: Call to a member function makeSound() on null'
echo $animal?->makeSound() . PHP_EOL; // solution: the null safe operator; $animal?->makeSound() returns null