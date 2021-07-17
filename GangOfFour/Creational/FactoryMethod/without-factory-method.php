<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Creational\WithoutFactoryMethod;

use RuntimeException;

abstract class Car
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

// Notice similarities to Simple Factory
class CarDealership
{
    public function __construct(private string $make) {}

    public function import(): Car
    {
        return match ($this->make) { // if a new car make is needed, CarDealership class has to be modified
            'Mercedes' => new Mercedes(),
            'Toyota' => new Toyota(),
            // Runtime exception is possible:
            default => throw new RuntimeException(message: "$this->make is not allowed.")
        };
    }

    public function sell(): void
    {
        $car = $this->import();
        $car->polishUp();
        $car->advertise();
        $car->testDrive();
    }
}

function clientCode(string $make): void
{
    $carDealership = new CarDealership(make: $make);
    $carDealership->sell();
}

// Application configuration decides which make it works with:
clientCode('Mercedes');
// or
clientCode('Toyota');