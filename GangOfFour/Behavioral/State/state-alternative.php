<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Behavioral\StateAlternative;

use ReflectionClass;

interface MotorPower
{
    function getIncreasedPower(): self;
    function getDecreasedPower(): self;
}

class MotorOff implements MotorPower
{
    public function getIncreasedPower() : MotorPower
    {
        return $this; // state does not change
    }

    function getDecreasedPower() : MotorPower
    {
        return $this;
    }
}

class NoMotorPower implements MotorPower
{
    public function getIncreasedPower(): MotorPower
    {
        return new LowMotorPower(); // decides the new state (no conditions here)
    }

    function getDecreasedPower(): MotorPower
    {
        return $this;
    }
}

class LowMotorPower implements MotorPower
{
    public function getIncreasedPower() : MotorPower
    {
        return new MediumMotorPower(); // the new state object that "Context" will use to assign to its state object
    }

    function getDecreasedPower() : MotorPower
    {
        return new NoMotorPower();
    }
}

class MediumMotorPower implements MotorPower
{
    public function getIncreasedPower(): MotorPower
    {
        return new HighMotorPower();
    }

    public function getDecreasedPower() : MotorPower
    {
        return new LowMotorPower();
    }
}

class HighMotorPower implements MotorPower
{
    public function getIncreasedPower() : MotorPower
    {
        return $this;
    }

    public function getDecreasedPower() : MotorPower
    {
        return new MediumMotorPower();
    }
}

class EBike
{
    private MotorPower $motorPower;

    public function __construct()
    {
        $this->setMotorPower(motorPower: new MotorOff());
    }

    // does not allow other objects to transition to a different state explicitly
    private function setMotorPower(MotorPower $motorPower): void
    {
        $this->motorPower = $motorPower;
    }

    // interface for clients:
    public function turnOn(): void
    {
        $this->setMotorPower(motorPower: new NoMotorPower());
    }

    public function pushPlusButton(): void
    {
        $this->setMotorPower($this->motorPower->getIncreasedPower());
    }

    public function pushMinusButton(): void
    {
        // if a state object needs access to a context, it can be passed via method or constructor parameter
        $this->setMotorPower($this->motorPower->getDecreasedPower());
    }

    public function __toString(): string
    {
        return (new ReflectionClass(objectOrClass: $this->motorPower))->getShortName();
    }
}

$eBike = new EBike(); // eBike is in MotorOff state

// the client code is not able to deal with the state object directly:
// $eBike->setMotorPower(new MediumMotorPower());
// but rather is forced to use the interface intended for clients:
$eBike->pushMinusButton(); // nothing changes
echo $eBike . PHP_EOL;
$eBike->pushPlusButton(); // nothing changes
echo $eBike . PHP_EOL;

$eBike->turnOn(); // eBike is in NoMotorPower state
echo $eBike . PHP_EOL;
$eBike->pushMinusButton(); // nothing changes
echo $eBike . PHP_EOL;

$eBike->pushPlusButton(); // eBike is in LowMotorPower state
echo $eBike . PHP_EOL;

$eBike->pushMinusButton(); // eBike is in NoMotorPower state
echo $eBike . PHP_EOL;

$eBike->pushPlusButton(); // eBike is in LowMotorPower state
echo $eBike . PHP_EOL;

$eBike->pushPlusButton(); // eBike is in MediumMotorPower state
echo $eBike . PHP_EOL;

$eBike->pushPlusButton(); // eBike is in HighMotorPower state
echo $eBike . PHP_EOL;
$eBike->pushPlusButton(); // nothing changes
echo $eBike . PHP_EOL;

$eBike->pushMinusButton(); // eBike is in MediumMotorPower state
echo $eBike . PHP_EOL;