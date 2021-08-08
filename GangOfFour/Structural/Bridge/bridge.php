<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Structural\Bridge;

// "Abstraction"
abstract class Remote
{
    public function __construct(private Device $device) {} // has an "Implementor"

    public function changeDevice(Device $device): void
    {
        $this->device = $device;
    }

    // Methods are implemented in terms of the implementation:
    protected function getVolume(): int
    {
        return $this->device->getVolume(); // uses "Implementor"
    }

    protected function setVolume(int $volume): void // not available in a public interface of the subclasses
    {
        $this->device->setVolume(volume: $volume);
    }
}

// "Refined Abstractions":
class BasicRemote extends Remote
{
    // Method is implemented in terms of the abstraction, not implementation
    public function setVolume(int $volume): void // changing visibility level
    {
        parent::setVolume(volume: $volume); // uses only "Abstraction", not "Implementor"
    }
}

class UserFriendlyRemote extends Remote
{
    // Methods are implemented in terms of the abstraction, not implementation:
    public function volumeUp(): void
    {
        // Uses only "Abstraction", not "Implementor":
        $currentVolume = $this->getVolume();
        $this->setVolume(volume: $currentVolume + 10);
    }

    public function volumeDown(): void
    {
        $currentVolume = $this->getVolume();
        $this->setVolume(volume: $currentVolume - 10);
    }

    public function mute(): void
    {
        $this->setVolume(volume: 0);
    }
}

// adding another interface (new kind of remote control) is easy - requires implementing only one new class

// "Implementor"
abstract class Device
{
    private int $volume = 40;

    public function getVolume(): int
    {
        return $this->volume;
    }

    public function setVolume(int $volume): void
    {
        if ($volume >= 0 && $volume <= 100) {
            $this->volume = $volume;
        }
        echo "Volume set to $volume%" . PHP_EOL;
    }
}

// "Concrete Implementors":
class Radio extends Device
{
    // standard implementation
}

class TV extends Device
{
    const UNSAFE_VOLUME_LEVEL = 70;

    public function setVolume(int $volume): void // different implementation
    {
        parent::setVolume(volume: $volume);
        if ($volume >= self::UNSAFE_VOLUME_LEVEL) {
            echo "WARNING: Listening for a prolonged period of time may damage your hearing!" . PHP_EOL;
        }
    }
}

// adding another implementation (new kind of device) is easy - requires implementing only one new class

// It is possible to pair any remote control (interface) with any device (implementation):
$radio = new Radio();
$basicRemote = new BasicRemote(device: $radio);
echo 'Basic remote paired with radio:' . PHP_EOL;
$basicRemote->setVolume(volume: 60); // standard interface to interact with the device

$tv = new TV();
$basicRemote->changeDevice(device: $tv); // implementation can be switched at run-time
echo 'Basic remote paired with TV:' . PHP_EOL;
$basicRemote->setVolume(volume: 60);

$userFriendlyRemote = new UserFriendlyRemote(device: $radio);
echo 'User-friendly remote paired with radio:' . PHP_EOL;
// Alternative interface to interact with the device:
$userFriendlyRemote->volumeUp();
$userFriendlyRemote->volumeDown();
$userFriendlyRemote->mute();

$userFriendlyRemote->changeDevice(device: $tv);
echo 'User-friendly remote paired with TV:' . PHP_EOL;
$userFriendlyRemote->volumeUp();
$userFriendlyRemote->volumeDown();
$userFriendlyRemote->mute();