<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Creational\Singleton;

trait Singleton
{
    private static ?self $instance = null;

    private function __construct() {}

    public static function getInstance(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}

final class Logger // defined final to prevent inheritance - disallows creation of the second object of the child class
{
    use Singleton;
}

// If Logger class was not defined as final, the following would enable creation of the second object:
/*class NewLogger extends Logger
{
  use Singleton;
}*/

// It is not possible to create a logger using 'new' keyword:
// $logger = new Logger(); // Call to 'private Singleton::__construct()' from invalid context

// The logger is accessible everywhere within the application:
$logger = Logger::getInstance(); // the only way to create a logger is to use a static function
$anotherLogger = Logger::getInstance(); // the second call to getInstance() returns the same object

if ($logger === $anotherLogger) {
    echo 'Both loggers reference the same object.' . PHP_EOL;
}