<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Behavioral\State;

use ReflectionClass;

// "State"
interface MotorPower // might be also an abstract class if needed
{
    function increasePower(EBike $eBike): void;
    function decreasePower(EBike $eBike): void;
}

// "Concrete States":
class MotorOff implements MotorPower // all behavior for a particular state is encapsulated in one object
{
    public function increasePower(EBike $eBike): void
    {
        // nothing happens
    }

    public function decreasePower(EBike $eBike): void
    {
        // nothing happens
    }
}

class NoMotorPower implements MotorPower
{
    public function increasePower(EBike $eBike): void
    {
        // other necessary actions might be performed here

        $eBike->setMotorPower(motorPower: new LowMotorPower()); // decides the new state (no conditions here)
    }

    public function decreasePower(EBike $eBike): void
    {
        // nothing happens
    }
}

class LowMotorPower implements MotorPower
{
    public function increasePower(EBike $eBike): void
    {
        $eBike->setMotorPower(motorPower: new MediumMotorPower()); // uses passed context to set its new state
    }

    public function decreasePower(EBike $eBike): void
    {
        $eBike->setMotorPower(motorPower: new NoMotorPower()); // alternatively, these methods could return
        // the new state object and "Context" would use them to assign to its state object
    }
}

class MediumMotorPower implements MotorPower
{
    public function increasePower(EBike $eBike): void
    {
        $eBike->setMotorPower(motorPower: new HighMotorPower()); // state transitions are explicit
    }

    public function decreasePower(EBike $eBike): void
    {
        $eBike->setMotorPower(motorPower: new LowMotorPower());
    }
}

// new states and transitions can be added easily by defining new subclasses
class HighMotorPower implements MotorPower
{
    public function increasePower(EBike $eBike): void
    {
        // nothing happens
    }

    public function decreasePower(EBike $eBike): void
    {
        $eBike->setMotorPower(motorPower: new MediumMotorPower());
    }
}

// "Context"
class EBike
{
    private MotorPower $motorPower; // defines the current state

    public function __construct()
    {
        $this->setMotorPower(motorPower: new MotorOff()); // "Context" decides the initial state here - fixed criteria
    }

    // allows other objects to transition to a different state
    public function setMotorPower(MotorPower $motorPower): void
    {
        $this->motorPower = $motorPower;
    }

    // interface of interest to clients:
    public function turnOn(): void
    {
        $this->setMotorPower(motorPower: new NoMotorPower());
    }

    public function pushPlusButton(): void
    {
        $this->motorPower->increasePower(eBike: $this); // delegates request to the current state object
    }

    public function pushMinusButton(): void
    {
        $this->motorPower->decreasePower(eBike: $this); // passes itself to the state object; alternatively,
                                                        // it could be done via the state's constructor parameter
    }

    public function __toString(): string
    {
        return (new ReflectionClass(objectOrClass: $this->motorPower))->getShortName();
    }
}

$eBike = new EBike(); // eBike is in MotorOff state

// once a context is configured (above), the client code does not have to deal with the state object directly:
// $eBike->setMotorPower(new MediumMotorPower()); // (if that should not be possible, see state-alternative.php)
// but rather should use the interface intended for clients:
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