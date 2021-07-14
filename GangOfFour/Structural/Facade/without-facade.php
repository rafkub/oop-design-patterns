<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Structural\WithoutFacade;

class Lights
{
    public function dim(): void
    {
        echo 'Lights dimmed.' . PHP_EOL;
    }
}

class Screen
{
    public function down(): void
    {
        echo 'Screen down.' . PHP_EOL;
    }
}

class Projector
{
    public function turnOn(): void
    {
        echo 'Projector turned on.' . PHP_EOL;
    }

    public function setInput(Input $input): void
    {
        echo "Projector input set to {$input->getName()}." . PHP_EOL;
    }
}

abstract class Input
{
    public function __construct(private string $name) {}

    public function getName(): string
    {
        return $this->name;
    }
}

class DVD extends Input
{
    public function __construct()
    {
        parent::__construct('DVD');
    }

    public function turnOn(): void
    {
        echo 'DVD turned on.' . PHP_EOL;
    }

    public function play(Movie $movie): void
    {
        echo "DVD playing {$movie->getTitle()}..." . PHP_EOL;
    }
}

class Movie
{
    public function __construct(private string $title) {}

    public function getTitle(): string
    {
        return $this->title;
    }
}

class Amplifier
{
    public function turnOn(): void
    {
        echo 'Amplifier turned on.' . PHP_EOL;
    }

    public function setVolume(int $level): void
    {
        echo "Volume set to $level." . PHP_EOL;
    }
}

// Client has to be knowledgeable about "subsystem classes" and do all the setup:
$lights = new Lights();
$lights->dim();

$screen = new Screen();
$screen->down();

$dvd = new DVD();

$projector = new Projector();
$projector->turnOn();
$projector->setInput(input: $dvd);

$amplifier = new Amplifier();
$amplifier->turnOn();
$amplifier->setVolume(level: 6);

$movie = new Movie(title: "Schindler's List");

$dvd->turnOn();
$dvd->play(movie: $movie);