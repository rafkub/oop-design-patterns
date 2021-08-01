<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Structural\WithoutComposite;

use SplObjectStorage;

// serves as the base class for primitive equipment
abstract class Part
{
    public function __construct(private int $weight) {}

    public function getWeight(): int
    {
        return $this->weight;
    }
}

// Primitive equipments:
class RAM extends Part
{
}

class CPU extends Part
{
}

class SSD extends Part
{
}

// serves as the base class for equipment that contains other equipment
abstract class CompositePart
{
    private SplObjectStorage $parts; // stores child components

    public function __construct(private int $weight)
    {
        $this->parts = new SplObjectStorage();
    }

    public function getTotalWeight(): int // calls operations of its children
    {
        $weight = 0;
        foreach ($this->parts as $part) {
            if ($part instanceof Part) { // type-checking is required, but see a note below
                $subpartsWeight = $part->getWeight(); // code for primitive objects
            } else {
                $subpartsWeight = $part->getTotalWeight(); // code for composite objects
            }
            $weight += $subpartsWeight; // calculates total weight of its subcomponents
        }
        return $weight + $this->weight; // adds its own weight
    }

    // Implements child-related operations:
    public function add(Part|CompositePart $part): void // type-hinting both base classes
    {
        $this->parts->attach(object: $part);
    }
    public function remove(Part|CompositePart $part): void
    {
        $this->parts->detach(object: $part);
    }
}

// Specific equipments that can contain other equipment:
class Motherboard extends CompositePart
{
}

class Computer extends CompositePart
{
}

function clientCode(Part|CompositePart $equipment): void // type-hinting both base classes
{
    // NOTE: PHP allows duck typing (it is enough to ensure that both Part and CompositePart classes
    // have the same named method - getWeight - to be used uniformly), so the code could be simplified to:
    // echo "Equipment weight: {$equipment->getWeight()} units." . PHP_EOL;
    // This means the following is a bit of a stretch to make the point. However, it actually proves that as a result
    // of the introduction of 'union types' in PHP 8, the need for the classic Composite pattern is diminished.
    if ($equipment instanceof Part) {
        echo "Equipment weight: {$equipment->getWeight()} units." . PHP_EOL; // code for primitive objects
    } else {
        echo "Equipment weight: {$equipment->getTotalWeight()} units." . PHP_EOL; // code for composite objects
    }
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
$computer->add(part: $motherboard); // recursive composition is possible
echo 'Computer:' . PHP_EOL;
clientCode(equipment: $computer);

// $cpu->add($ram); // static code analysis error: Method 'add' not found in CPU