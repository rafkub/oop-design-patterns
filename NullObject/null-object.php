<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\NullObject;

interface Animal
{
    public function makeSound(): string; // could be also ?string and then NullAnimal might return null
}

class Dog implements Animal
{
    public function makeSound(): string
    {
        return "Woof!";
    }
}

class NullAnimal implements Animal
{
    public function makeSound(): string
    {
        return ''; // no sound
    }
}

$animal = new Dog();
echo $animal->makeSound() . PHP_EOL;

$animal = new NullAnimal(); // null object
echo $animal->makeSound() . PHP_EOL; // no null check required