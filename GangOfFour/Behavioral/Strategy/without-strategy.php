<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Behavioral\WithoutStrategy;

// if implementation of Windows type is required, the class has to be modified, thus violating the Open Closed Principle
class TextProcessor
{
    public function __construct(private array $lines) {}

    public function getFormattedText(string $type): string
    {
        $linesSeparator = match ($type) {
            'Web' => '<br>',
            'Unix' => "\n", // it cannot be PHP_EOL constant as this script might be executed on Windows
            default => ' ',
        };
        return implode(separator: $linesSeparator, array: $this->lines);
    }
}

$lines = ['line 1', 'line 2'];
$textProcessor = new TextProcessor(lines: $lines);
echo $textProcessor->getFormattedText(type: 'Web') . PHP_EOL;