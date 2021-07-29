<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Behavioral\Command;

use SplStack;

// "Command"
interface Command
{
    function execute(): void;
    function undo(): void;
}

// "Concrete Commands":
class Write implements Command
{
    public function __construct(private Document $document, private string $text) {}

    function execute(): void
    {
        $this->document->write(text: $this->text); // delegates action to a receiver
    }

    function undo(): void
    {
        $this->document->removeLastCharacters(amount: strlen($this->text)); // delegates action to a receiver
    }
}

// it is easy to add a new command - a new class implementing Command interface needs to be developed
class Backspace implements Command
{
    private string $text = '';

    public function __construct(private Document $document) {}

    function execute(): void
    {
        $this->text = $this->document->removeLastCharacters(amount: 1);
    }

    function undo(): void
    {
        $this->document->write(text: $this->text);
    }
}

// "Receiver" - performs business logic; has no knowledge of "Invoker" (Application)
class Document
{
    private string $text = '';

    public function write(string $text): void
    {
        $this->text .= $text;
    }

    public function removeLastCharacters(int $amount): string
    {
        $removed = mb_substr(string: $this->text, start: strlen($this->text) - $amount);
        $this->text = mb_substr(string: $this->text, start: 0, length: strlen($this->text) - $amount);
        return $removed;
    }

    public function getContent(): string
    {
        return $this->text;
    }
}

// "Invoker" - has no knowledge of "Receiver" (Document)
class Application
{
    private SplStack $history; // maintains history list of commands

    public function __construct()
    {
        $this->history = new SplStack();
    }

    public function run(Command $command): void
    {
        $command->execute();
        $this->history->push(value: $command); // in this case no need to copy a command before adding it to the history
    }

    public function undo(): void
    {
        if ($this->history->isEmpty()) {
            echo 'History is empty, nothing to undo.' . PHP_EOL;
            return;
        }
        $command = $this->history->pop();
        $command->undo();
    }
}

$document = new Document();
$app = new Application();
$app->undo();
// "Client":
$app->run(command: new Write(document: $document, text: 'a'));
$app->run(command: new Write(document: $document, text: 'b')); // a command is replaced dynamically
$app->undo(); // revert writing 'b'
$app->run(command: new Write(document: $document, text: 'c'));
$app->run(command: new Write(document: $document, text: 'd')); // write 'd'
$app->run(command: new Backspace(document: $document)); // delete 'd'
$app->run(command: new Backspace(document: $document)); // delete 'c'
$app->undo(); // revert backspace that deleted 'c'
$app->undo(); // revert backspace that deleted 'd'
$app->undo(); // revert writing 'd'
$app->run(command: new Write(document: $document, text: 'e'));
echo $document->getContent() . PHP_EOL;