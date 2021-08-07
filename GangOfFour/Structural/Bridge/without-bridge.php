<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Structural\WithoutBridge;

abstract class Remote
{
    private int $volume = 40;

    public function setVolume(int $volume): void
    {
        if ($volume >= 0 && $volume <= 100) {
            $this->volume = $volume;
        }
        echo "Volume set to $this->volume%" . PHP_EOL;
    }
}

class RemoteForRadio extends Remote
{
    // default implementation
}

class RemoteForTV extends Remote
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

// Adding another implementation requires implementing one new classes,
// but adding another, separate interface is impossible, because every remote has the same, fixed abstraction (Remote)

$remoteForRadio = new RemoteForRadio();
echo 'Remote for radio:' . PHP_EOL;
$remoteForRadio->setVolume(volume: 60); // only standard interface to interact with the device is available
$remoteForRadio->setVolume(volume: 70);

$remoteForTV = new RemoteForTV();
echo 'Remote for TV:' . PHP_EOL;
$remoteForTV->setVolume(volume: 60);
$remoteForTV->setVolume(volume: 70);

// Having a separate, alternative interface (without modifying Remote) to interact with the device would be nice:
// $userFriendlyRemoteForTV->volumeUp();
// $userFriendlyRemoteForRadio->volumeDown();
// $userFriendlyRemoteForTV->mute();
// It might be accomplished to some extent by creating two new classes:
// UserFriendlyRemoteForTV and UserFriendlyRemoteForTV, but it leads to class proliferation and would create
// an extended interface (containing also setVolume() method) and not an alternative one.