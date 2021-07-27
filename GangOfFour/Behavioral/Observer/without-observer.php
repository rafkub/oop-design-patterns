<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Behavioral\WithoutObserver;

class DownCounter
{
    public function __construct(private int $value) {} // state

    public function tick(): void
    {
        $this->value--;
    }

    public function set(int $value): void
    {
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}

class Buzzer
{
    public function buzz(): void
    {
        echo 'Buzzing!' . PHP_EOL;
    }
}

class Beeper
{
    public function beep(): void
    {
        echo 'Beeping!' . PHP_EOL;
    }
}

$downCounter = new DownCounter(value: 3);
$buzzer = new Buzzer();
$beeper = new Beeper();
echo 'First tick' . PHP_EOL;
$downCounter->tick(); // each time tick happens
if ($downCounter->getValue() === 0) { // DownCounter object state has to be checked
    // and appropriate actions have to be taken:
    $buzzer->buzz();
    $beeper->beep();
}
echo 'Second tick' . PHP_EOL;
$downCounter->tick();
if ($downCounter->getValue() === 0) {
    $buzzer->buzz();
    $beeper->beep();
}
echo 'Third tick' . PHP_EOL;
$downCounter->tick();
if ($downCounter->getValue() === 0) {
    $buzzer->buzz();
    $beeper->beep();
}

$downCounter->set(value: 1);
echo 'First tick after resetting' . PHP_EOL;
$downCounter->tick();
if ($downCounter->getValue() === 0) {
    $beeper->beep(); // this time only one object should react
}