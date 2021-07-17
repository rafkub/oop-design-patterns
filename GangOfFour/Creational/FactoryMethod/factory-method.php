<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Creational\FactoryMethod;

abstract class Car // "Product"
{
    function polishUp(): void
    {
        echo 'Polishing up bodywork, rims and shine-spraying tires...' . PHP_EOL;
    }

    abstract function advertise(): void;

    public function testDrive(): void
    {
        echo 'Test drive...' . PHP_EOL;
    }
}

// "Concrete Products":
class Mercedes extends Car
{
    public function advertise(): void
    {
        echo 'German practical advertisement.' . PHP_EOL;
    }
}

class Toyota extends Car
{
    public function advertise(): void
    {
        echo 'Japanese anime ad.' . PHP_EOL;
    }
}

// "Creator" declares a factory method that can be used instead of the constructor
abstract class CarDealership
{
    abstract public function import(): Car; // factory method declaration; no reasonable default implementation here

    // Usually, "Creator" contains some business logic that relies on "Product" object, returned by the factory method
    public function sell(): void
    {
        $car = $this->import(); // instantiation of the concrete class is deferred to a subclass
        $car->polishUp();
        $car->advertise();
        $car->testDrive();
    }
}

//"Concrete Creators":
class MercedesDealership extends CarDealership
{
    public function import(): Car // factory method implementation
    {
        return new Mercedes();
    }
}

class ToyotaDealership extends CarDealership
{
    public function import(): Car // factory method implementation
    {
        return new Toyota();
    }
}

// Client code does not rely on concrete classes:
function clientCode(CarDealership $carDealership): void
{
    $carDealership->sell();
}

// Application configuration decides which make it works with:
clientCode(new MercedesDealership());
// or
clientCode(new ToyotaDealership());