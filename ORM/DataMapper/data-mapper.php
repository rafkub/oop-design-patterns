<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\ORM\DataMapper;

class Person
{
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
}

// Data Mapper:
class PersonMapper
{
    public function store(Person $person): void
    {
        echo "Storing $person in a database..." . PHP_EOL;
    }

    public function retrieve(string $name): Person
    {
        echo "Loading data from a database for $name..." . PHP_EOL;
        $person = new Person();
        $person->setName(name: $name);
        $person->setPhoneNumber(phoneNumber: "555-0" . rand(min: 100, max: 199));
        return $person;
    }
}

$person = new Person();
$person->setName(name: 'Tom');
$person->setPhoneNumber(phoneNumber: '555-0100');

$personMapper = new PersonMapper();
$personMapper->store(person: $person);

$person = $personMapper->retrieve(name: 'Eva');
echo $person . PHP_EOL;