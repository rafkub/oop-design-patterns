<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Creational\WithoutSingleton;

class Logger
{
}

$logger = new Logger(); // instantiation of a global object which is accessible everywhere within the application
$anotherLogger = new Logger(); // but the second instantiation call is possible which returns a separate object

if ($logger !== $anotherLogger) {
    echo 'Loggers reference different objects.' . PHP_EOL;
}