<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Behavioral\CustomPushObserver;

use SplObjectStorage;

interface Subject // "Subject"
{
    function attach(Observer $observer): void;
    function detach(Observer $observer): void;
    function notify(): void;
}

// "Concrete Subject":
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
            $observer->update(subject: $this, data: $this->value);
        }
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

interface Observer // "Observer"
{
    public function update(Subject $subject, int $data): void; // push model: data passed as a second argument
}

// "Concrete Observers":
class Buzzer implements Observer
{
    public function buzz(int $data): void
    {
        echo "Buzzing! Subject's data: $data." . PHP_EOL;
    }

    public function update(Subject $subject, int $data): void
    {
        $this->buzz(data: $data);
    }
}

class Beeper implements Observer
{
    public function beep(int $data): void
    {
        echo "Beeping! Subject's data: $data." . PHP_EOL;
    }

    public function update(Subject $subject, int $data): void
    {
        $this->beep(data: $data);
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