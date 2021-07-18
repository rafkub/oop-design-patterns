<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Creational\WithoutAbstractFactory;

//Family of products:
abstract class Phone
{
    public function call(): void
    {
        echo 'Calling...' . PHP_EOL;
    }

    abstract public function text(): void;
}

abstract class Tablet
{
    abstract public function browse(): void;
}

// Apple family of products:
class iPhone extends Phone
{
    public function text(): void
    {
        echo "Sending iMessage..." . PHP_EOL;
    }
}

class iPad extends Tablet
{
    public function browse(): void
    {
        echo 'Browsing the internet using Safari...' . PHP_EOL;
    }
}

// Samsung family of products:
class Galaxy extends Phone
{
    public function text(): void
    {
        echo "Sending via Android Messages..." . PHP_EOL;
    }
}

class GalaxyTab extends Tablet
{
    public function browse(): void
    {
        echo 'Browsing the internet using Browse...' . PHP_EOL;
    }
}

// Client code relies on concrete classes:
function clientCode(string $brand): void
{
    if ($brand === 'Apple') { // conditional checks required in each place an instantiation of products occur
        $phone = new iPhone();
        $phone->call();
        $phone->text();

        $tablet = new iPad();
        $tablet->browse();
    } elseif ($brand === 'Samsung') {
        $phone = new Galaxy();
        $phone->call();
        $phone->text();

        $tablet = new GalaxyTab();
        $tablet->browse();
    }
}

// Application configuration decides which family of products it works with:
clientCode(brand: 'Apple');
// or
clientCode(brand: 'Samsung');