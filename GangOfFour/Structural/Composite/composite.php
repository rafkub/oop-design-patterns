<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Structural\Composite;

use RuntimeException;
use SplObjectStorage;

// "Component"
abstract class Part
{
    public function __construct(private int $weight) {}

    // the interface for objects in the composition
    public function getWeight(): int
    {
        return $this->weight; // implements default behavior for the interface common to all classes
    }

    // declares an interface for accessing and managing its child components
    public function add(Part $part): void
    {
        throw new RuntimeException(message: 'This is incorrect operation.'); // default for "Leaf" objects
    }
    public function remove(Part $part): void
    {
        throw new RuntimeException(message: 'This is incorrect operation.'); // redefined in the "Composite"
    }
}

// "Leaves" (primitives):
class RAM extends Part // subclasses "Component"
{ // does not implement child-related operations (inherits default ones that throw an exception)
}

class CPU extends Part
{ // default implementation of getWeight() is correct for all the "leaves"
}

class SSD extends Part
{
}

// "Composite" - serves as the base class for equipment that contains other equipment
abstract class CompositePart extends Part // implements "Component"
{
    private SplObjectStorage $parts; // stores child components

    public function __construct(int $weight)
    {
        parent::__construct(weight: $weight);
        $this->parts = new SplObjectStorage();
    }

    public function getWeight(): int // calls operations of its children
    {
        $weight = 0;
        foreach ($this->parts as $part) {
            $weight += $part->getWeight(); // calculates total weight of its subcomponents
        }
        return $weight + parent::getWeight(); // adds its own weight
    }

    // Implements child-related operations:
    public function add(Part $part): void
    {
        $this->parts->attach(object: $part);
    }
    public function remove(Part $part): void
    {
        $this->parts->detach(object: $part);
    }
}

// Specific equipment that contains other equipment:
class Motherboard extends CompositePart
{
}

class Computer extends CompositePart
{
}

// "Client"
function clientCode(Part $equipment): void
{
    echo "Equipment weight: {$equipment->getWeight()} units." . PHP_EOL; // same code for "Leaf" and "Composite" objects
}

$cpu = new CPU(weight: 200);
echo 'CPU:' . PHP_EOL;
clientCode(equipment: $cpu); // client code can process a "Leaf" object

$ram = new RAM(weight: 50);
$motherboard = new Motherboard(weight: 100);
$motherboard->add(part: $cpu);
$motherboard->add(part: $ram);
echo 'Motherboard:' . PHP_EOL;
clientCode(equipment: $motherboard); // client code can also process a "Composite" object

$ssd = new SSD(weight: 400);
$computer = new Computer(weight: 1000);
$computer->add(part: $ssd);
$computer->add(part: $motherboard); // recursive composition is possible
echo 'Computer:' . PHP_EOL;
clientCode(equipment: $computer);

// $cpu->add($ram); // downside of the classic Composite pattern: run-time error for incorrect operation