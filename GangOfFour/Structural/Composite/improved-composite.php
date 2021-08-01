<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Structural\ImprovedComposite;

use SplObjectStorage;

interface Equipment // base interface for primitives and composites
{
    function getWeight(): int; // common method for primitives and composites
}

// serves as the base class for primitive equipment - does not declare nor define any child-related operations
abstract class Part implements Equipment
{
    public function __construct(private int $weight) {}

    public function getWeight(): int
    {
        return $this->weight;
    }
}

class RAM extends Part
{ // no child-related operations
}

class CPU extends Part
{ // default implementation of getWeight() is correct for all the "leaves"
}

class SSD extends Part
{
}

// serves as the base class for equipment that contains other equipment
abstract class CompositePart implements Equipment
{
    private SplObjectStorage $parts; // stores child components

    public function __construct(private int $weight)
    {
        $this->parts = new SplObjectStorage();
    }

    public function getWeight(): int // calls operations of its children
    {
        $weight = 0;
        foreach ($this->parts as $part) {
            $weight += $part->getWeight(); // calculates total weight of its subcomponents
        }
        return $weight + $this->weight; // adds its own weight
    }

    // Implements child-related operations:
    public function add(Equipment $part): void
    {
        $this->parts->attach(object: $part);
    }
    public function remove(Equipment $part): void
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

function clientCode(Equipment $equipment): void // type-hinting base interface
{
    echo "Equipment weight: {$equipment->getWeight()} units." . PHP_EOL; // same code for primitive and composite object
}

$cpu = new CPU(weight: 200);
echo 'CPU:' . PHP_EOL;
clientCode(equipment: $cpu); // client code can process a primitive object

$ram = new RAM(weight: 50);
$motherboard = new Motherboard(weight: 100);
$motherboard->add(part: $cpu);
$motherboard->add(part: $ram);
echo 'Motherboard:' . PHP_EOL;
clientCode(equipment: $motherboard); // client code can also process an object being composed of primitive objects

$ssd = new SSD(weight: 400);
$computer = new Computer(weight: 1000);
$computer->add(part: $ssd);
$computer->add(part: $motherboard); // recursive composition is also possible
echo 'Computer:' . PHP_EOL;
clientCode(equipment: $computer);

// $cpu->add($ram); // static code analysis error: Method 'add' not found in CPU
// NOTE: The above approach proves to be the best of both worlds: defining the child management interface in its right
// place, that is in the "Composite", which gives type safety but without sacrificing transparency,
// because leaves and composites have the same interface: Equipment.