<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\Creational\DependencyInjection;

class Car
{
    private CombustionEngine $engine;

    public function __construct(CombustionEngine $engine) // car's dependency is injected via constructor parameter
    {
        $this->engine = $engine; // no hard-coded dependency - an engine is produced externally
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

$combustionEngine = new CombustionEngine('1.4L');
$car = new Car($combustionEngine); // injection of a specific combustion engine
$car->start();

$combustionEngine = new CombustionEngine('2.0L');
$car = new Car($combustionEngine); // a different combustion engine can be put into the car
$car->start();

// NOTE:
// Even though dependency injection technique is used, the above example still violates Dependency Inversion Principle.
// See how the above code is a starting point (dependency-inversion-violation.php) to illustrate it
// and how dependency-inversion.php is the solution (rafkub\oop-principles repository, SOLID\DependencyInversion\).