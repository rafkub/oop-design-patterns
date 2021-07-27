<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Behavioral\Observer;

use SplObjectStorage;
use SplObserver;
use SplSubject;

// "Concrete Subject":
trait Subject
{
    private SplObjectStorage $observers;

    public function attach(SplObserver $observer): void
    {
        $this->observers->attach($observer);
    }

    public function detach(SplObserver $observer): void
    {
        $this->observers->detach($observer);
    }

    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update(subject: $this);
        }
    }
}

class DownCounter implements SplSubject
{
    use Subject;

    public function __construct(private int $value) // state
    {
        $this->observers = new SplObjectStorage();
    }

    public function tick(): void
    {
        $this->value--;
        if ($this->value === 0) {
            $this->notify(); // when a particular state change happens, notify all observers
        }
    }

    public function set(int $value): void
    {
        $this->value = $value;
    }
}

// "Concrete Observers":
class Buzzer implements SplObserver
{
    public function buzz(): void
    {
        echo 'Buzzing!' . PHP_EOL;
    }

    // SplObserver method:
    public function update(SplSubject $subject): void
    {
        $this->buzz(); // in this case accessing subject's state is not required
        // However, if an observer requires access to subject's state there are three approaches:
        // a. push model: pass a second parameter with data when calling update()
        // (without changing its signature or changing its signature with a default value of the second argument)
        // and access it here using func_get_arg(1)
        // b. pull model: add getter(s) to subject and use them here to get required data (checking subject's type)
        // c. implement own "Subject" and "Observer" interfaces with custom signature of update (push) or getters (pull)
    }
}

class Beeper implements SplObserver
{
    public function beep(): void
    {
        echo 'Beeping!' . PHP_EOL;
    }

    public function update(SplSubject $subject): void
    {
        $this->beep();
    }
}

$downCounter = new DownCounter(value: 3);
$buzzer = new Buzzer();
$downCounter->attach(observer: $buzzer);
$beeper = new Beeper();
$downCounter->attach(observer: $beeper);
echo 'First tick' . PHP_EOL;
$downCounter->tick();
echo 'Second tick' . PHP_EOL;
$downCounter->tick();
echo 'Third tick' . PHP_EOL;
$downCounter->tick();

$downCounter->set(value: 1);
$downCounter->detach(observer: $buzzer);
echo 'First tick after resetting' . PHP_EOL;
$downCounter->tick();