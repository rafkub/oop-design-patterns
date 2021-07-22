<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\ORM\ActiveRecord;

class Person
{
    // Database table columns:
    private string $name;
    private string $phoneNumber;

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function __toString(): string
    {
        return "$this->name (tel. $this->phoneNumber)";
    }

    // Database-related operations:
    public function store(): void
    {
        echo "Storing $this in a database..." . PHP_EOL;
    }

    public function load(string $name): void
    {
        echo "Loading data from a database for $name..." . PHP_EOL;
        $this->name = $name;
        $this->phoneNumber = "555-0" . rand(min: 100, max: 199);
    }
}

$person = new Person();
$person->setName(name: 'Tom');
$person->setPhoneNumber(phoneNumber: '555-0100');
$person->store();

$person->load(name: 'Eva');
echo $person . PHP_EOL;