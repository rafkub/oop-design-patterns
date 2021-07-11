<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\WithoutDependencyInjection;

class Car
{
    private CombustionEngine $engine;

    public function __construct()
    {
        $this->engine = new CombustionEngine('1.4L'); // hard-coded dependency - a car produces the engine internally
    }

    public function start(): void
    {
        $this->engine->turnOn(); // a car uses - or depends on - the engine
    }
}

class CombustionEngine
{
    private string $size;

    public function __construct(string $size)
    {
        $this->size = $size;
    }

    public function turnOn(): void
    {
        echo "Starting $this->size engine. Ignition..." . PHP_EOL;
    }
}

$car = new Car(); // a car can be assembled only with a specific, pre-made combustion engine
$car->start();