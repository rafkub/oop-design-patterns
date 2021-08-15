<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Behavioral\Memento;

use Exception;

// "Originator"
class Client
{
    public function __construct(private string $name) {} // an internal state

    public function changeName(string $newName): void // changes internal state
    {
        $this->name = $newName;
    }

    public function createSnapshot(): ClientSnapshot
    {
        return new ClientSnapshot(state: $this->name); // initializes the memento with the current state
    }

    public function restoreFrom(ClientSnapshot $clientSnapshot): void
    {
        $this->name = $clientSnapshot->getState(); // uses the memento to restore the internal state
    }

    public function __toString(): string
    {
        return "Client's internal state: $this->name";
    }
}

// "Memento"
class ClientSnapshot
{
    public function __construct(private string $state) {} // records the internal state of the client object

    private function getState(): string // narrow interface: restricting access by making the method private
    {
        return $this->state;
    }

    /**
     * @throws Exception
     */
    public function __call(string $name, array $arguments): mixed // implements wide interface
    {
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        // allows only "Originator" to call restricted methods
        if ($trace && isset($trace[1]['class']) && $trace[1]['class'] === Client::class) {
            return $this->$name(...$arguments);
        }
        throw new Exception("Class method $name cannot be accessed" );
    }
}

// "Caretaker"
$client = new Client(name: 'Bill');
echo $client . PHP_EOL;
$clientSnapshot = $client->createSnapshot();
$client->changeName(newName: 'Vicky');
echo $client . PHP_EOL;
$client->restoreFrom($clientSnapshot);
echo $client . PHP_EOL;
// "Caretaker" cannot examine the content of a memento:
// echo $clientSnapshot->getState(); // throws exception: Class method getState cannot be accessed