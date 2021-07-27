<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Behavioral\CustomPullObserver;

use SplObjectStorage;

// "Subject"
interface Subject
{
    function attach(Observer $observer): void;
    function detach(Observer $observer): void;
    function notify(): void;
    function getData(): int; // pull model
}

// "Concrete Subject"
trait DownCounterSubject
{
    private SplObjectStorage $observers;

    public function attach(Observer $observer): void
    {
        $this->observers->attach($observer);
    }

    public function detach(Observer $observer): void
    {
        $this->observers->detach($observer);
    }

    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update(subject: $this);
        }
    }

    public function getData(): int
    {
        return $this->value;
    }
}

class DownCounter implements Subject
{
    use DownCounterSubject;

    public function __construct(private int $value) // state
    {
        $this->observers = new SplObjectStorage();
    }

    public function tick(): void
    {
        $this->value--;
        $this->notify(); // when a state changes, notify all observers
    }
}

// "Observer"
interface Observer
{
    public function update(Subject $subject): void;
}

// "Concrete Observers"
class Buzzer implements Observer
{
    public function buzz(int $data): void
    {
        echo "Buzzing! Subject's data: $data." . PHP_EOL;
    }

    public function update(Subject $subject): void
    {
        $this->buzz(data: $subject->getData()); // retrieving subject's state
    }
}

class Beeper implements Observer
{
    public function beep(int $data): void
    {
        echo "Beeping! Subject's data: $data." . PHP_EOL;
    }

    public function update(Subject $subject): void
    {
        $this->beep(data: $subject->getData());
    }
}

$downCounter = new DownCounter(value: 3);
$buzzer = new Buzzer();
$downCounter->attach(observer: $buzzer);
$beeper = new Beeper();
$downCounter->attach(observer: $beeper);

$downCounter->tick();
$downCounter->tick();

$downCounter->detach(observer: $buzzer);

$downCounter->tick();