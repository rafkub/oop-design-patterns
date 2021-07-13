<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Behavioral\Strategy;

// "Context" is configured with a "ConcreteStrategy" object:
class TextProcessor
{
    public function __construct(private array $lines) {}

    // "Context" uses "Strategy" interface to call the algorithm defined by a "ConcreteStrategy":
    public function getFormattedText(LinesSeparatorStrategy $linesSeparatorStrategy): string
    {
        // TextProcessor is not concerned about technical details of merging lines,
        // it rather forwards this task to injected strategy:
        return $linesSeparatorStrategy->getFormattedText(lines: $this->lines);
    }
}

// "Strategy" declares an interface common to all supported algorithms:
interface LinesSeparatorStrategy
{
    function getFormattedText(array $lines): string;
}

// "ConcreteStrategy" implements the algorithm using the Strategy interface:
class WebStrategy implements LinesSeparatorStrategy
{
    function getFormattedText(array $lines): string
    {
        return implode(separator: '<br>', array: $lines);
    }
}

// Another "ConcreteStrategy" implements the algorithm using the Strategy interface:
class UnixStrategy implements LinesSeparatorStrategy
{
    function getFormattedText(array $lines): string
    {
        return implode(separator: "\n", array: $lines);
    }
}

// if implementation of Windows type is required, a new WindowsStrategy class has to be implemented

$lines = ['line 1', 'line 2'];
$textProcessor = new TextProcessor(lines: $lines);
// Client code specifies which strategy to use:
$strategy = new WebStrategy();
echo $textProcessor->getFormattedText(linesSeparatorStrategy: $strategy) . PHP_EOL;