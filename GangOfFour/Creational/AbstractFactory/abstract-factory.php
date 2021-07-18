<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Creational\AbstractFactory;

// Family of products:
abstract class Phone // "Abstract Product"
{
    public function call(): void
    {
        echo 'Calling...' . PHP_EOL;
    }

    abstract public function text(): void;
}

abstract class Tablet // "Abstract Product"
{
    abstract public function browse(): void;
}

// "Concrete Products":
// Apple family:
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

// Samsung family:
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

// "Abstract Factory" declares an interface for operations that create abstract product objects
interface MobileDeviceFactory
{
    function createPhone(): Phone;
    function createTablet(): Tablet;
}

// "Concrete Factories" implement the operations to create a family of concrete product objects:
class AppleFactory implements MobileDeviceFactory
{
    function createPhone(): Phone
    {
        return new iPhone();
    }

    function createTablet(): Tablet
    {
        return new iPad();
    }
}

class SamsungFactory implements MobileDeviceFactory
{
    function createPhone(): Phone
    {
        return new Galaxy();
    }

    function createTablet(): Tablet
    {
        return new GalaxyTab();
    }
}

// Client code does not rely on concrete classes:
function clientCode(MobileDeviceFactory $mobileDeviceFactory): void
{
    $phone = $mobileDeviceFactory->createPhone();
    $phone->call();
    $phone->text();

    $tablet = $mobileDeviceFactory->createTablet();
    $tablet->browse();
}

// Application configuration decides which family of products it works with:
clientCode(mobileDeviceFactory: new AppleFactory());
// or
clientCode(mobileDeviceFactory: new SamsungFactory());