<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Behavioral\WithoutCommand;

use SplStack;

class Document
{
    private string $text = '';

    public function write(string $text): void
    {
        $this->text .= $text;
    }

    // Adding a new command requires opening this class for modification:
    // - new methods need to be implemented (doSomething() und undoSomething())
    public function backspace(): string
    {
        $lastCharacter = mb_substr($this->text, -1, 1);
        $this->text = mb_substr($this->text, 0, -1);
        return $lastCharacter;
    }

    public function undoWrite(string $text)
    {
        $this->text = mb_substr($this->text, 0, strlen($this->text) - strlen($text));
    }

    public function undoBackspace(string $text)
    {
        $this->text .= $text;
    }

    public function getContent(): string
    {
        return $this->text;
    }
}

class Application // is coupled with Document
{
    private SplStack $history; // maintains history list of commands

    public function __construct(private Document $document)
    {
        $this->history = new SplStack();
    }

    // Adding a new command requires opening this class for modification:
    // 1. adding a method mirroring doSomething() defined in Document class
    // 2. amending undo() to call undoSomething()
    public function write(string $text): void
    {
        $this->document->write(text: $text);
        $this->history->push(['operation' => 'write', 'data' => $text]);
    }

    public function backspace()
    {
        $text = $this->document->backspace();
        $this->history->push(['operation' => 'backspace', 'data' => $text]);
    }

    public function undo()
    {
        if ($this->history->isEmpty()) {
            echo 'History is empty, nothing to undo.' . PHP_EOL;
            return;
        }
        $lastOperation = $this->history->pop();
        switch ($lastOperation['operation']) {
            case 'write':
                $this->document->undoWrite($lastOperation['data']);
                break;
            case 'backspace':
                $this->document->undoBackspace($lastOperation['data']);
                break;
        }
    }
}

$document = new Document();
$app = new Application(document: $document);
$app->undo();
// Generally, this approach does not allow replacing commands dynamically.
// However, in PHP it is possible using e.g. $object->{$method}(); as follows:
// $method = 'backspace'; // or 'write'
// $params = []; // or ['d']
// $app->{$method}(...$params);
// or using call_user_func:
// call_user_func([$app, $method], ...$params);
// or using reflection:
// $reflectionMethod = new ReflectionMethod(Application::class, $method);
// $reflectionMethod->invoke($app, ...$params);
$app->write('a');  // a
$app->write('b');  // ab
$app->undo();      // a
$app->write('c');  // ac
$app->write('d');  // acd
$app->backspace(); // ac
$app->backspace(); // a
$app->undo();      // ac
$app->undo();      // acd
$app->undo();      // ac
$app->write('e');  // ace
echo $document->getContent() . PHP_EOL;