<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Behavioral\WithoutState;

use ReflectionClass;

class EBike // new states and transitions cannot be added easily - this class has to be modified in several places
{
    private int $motorPower = self::MOTOR_OFF; // represents internal state
    // Possible internal states:
    private const MOTOR_OFF = -1;
    private const NO_MOTOR_POWER = 0;
    private const LOW_MOTOR_POWER = 1;
    private const MEDIUM_MOTOR_POWER = 2;
    private const HIGH_MOTOR_POWER = 3;
    // 1. a new constant has to be created

    public function turnOn()
    {
        $this->motorPower = self::NO_MOTOR_POWER;
    }

    public function pushPlusButton()
    {
        if ($this->motorPower === self::NO_MOTOR_POWER) { // many conditional statements
            $this->motorPower = self::LOW_MOTOR_POWER; // in real-life situations their body might be much bigger
        } elseif ($this->motorPower === self::LOW_MOTOR_POWER) {
            $this->motorPower = self::MEDIUM_MOTOR_POWER;
        } elseif ($this->motorPower === self::MEDIUM_MOTOR_POWER) {
            $this->motorPower = self::HIGH_MOTOR_POWER;
        } // 2. another elseif branch has to be created
    }

    public function pushMinusButton()
    {
        if ($this->motorPower === self::LOW_MOTOR_POWER) {
            $this->motorPower = self::NO_MOTOR_POWER;
        } elseif ($this->motorPower === self::MEDIUM_MOTOR_POWER) {
            $this->motorPower = self::LOW_MOTOR_POWER;
        } elseif ($this->motorPower === self::HIGH_MOTOR_POWER) {
            $this->motorPower = self::MEDIUM_MOTOR_POWER;
        } // 3. another elseif branch has to be created
    }

    public function __toString(): string
    {
        $class = new ReflectionClass(__CLASS__);
        $constants = array_flip($class->getConstants());
        return $constants[$this->motorPower];
    }
}

$eBike = new EBike(); // eBike is in MOTOR_OFF state
$eBike->pushMinusButton(); // nothing happens
echo $eBike . PHP_EOL;
$eBike->pushPlusButton(); // nothing happens
echo $eBike . PHP_EOL;

$eBike->turnOn(); // eBike is in NO_MOTOR_POWER state
echo $eBike . PHP_EOL;
$eBike->pushMinusButton(); // nothing happens
echo $eBike . PHP_EOL;

$eBike->pushPlusButton(); // eBike is in LOW_MOTOR_POWER state
echo $eBike . PHP_EOL;

$eBike->pushMinusButton(); // eBike is in NO_MOTOR_POWER state
echo $eBike . PHP_EOL;

$eBike->pushPlusButton(); // eBike is in LOW_MOTOR_POWER state
echo $eBike . PHP_EOL;

$eBike->pushPlusButton(); // eBike is in MEDIUM_MOTOR_POWER state
echo $eBike . PHP_EOL;

$eBike->pushPlusButton(); // eBike is in HIGH_MOTOR_POWER state
echo $eBike . PHP_EOL;
$eBike->pushPlusButton(); // nothing happens
echo $eBike . PHP_EOL;

$eBike->pushMinusButton(); // eBike is in MEDIUM_MOTOR_POWER state
echo $eBike . PHP_EOL;