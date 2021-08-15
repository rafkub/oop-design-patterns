<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Behavioral\WithoutMemento;

class Client
{
    public function __construct(private string $name) {} // an internal state

    public function changeName(string $newName): void // changes internal state
    {
        $this->name = $newName;
    }

    // saving current state requires exposing it to the outer world which might violate encapsulation
    public function getName(): string
    {
        return $this->name;
    }

    public function __toString(): string
    {
        return "Client's internal state: $this->name";
    }
}

$client = new Client(name: 'Bill');
echo $client . PHP_EOL;
$savedState = $client->getName(); // saving current state
$client->changeName(newName: 'Vicky'); // changing internal state
echo $client . PHP_EOL;
$client->changeName(newName: $savedState); // restoring internal state
echo $client . PHP_EOL;