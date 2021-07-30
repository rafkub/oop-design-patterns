<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Structural\Decorator;

// "Component"
interface TextFormatter // defines common interface for base object and its decorators
{
    function format(string $text): string;
}

// "Concrete Component"
class PlainText implements TextFormatter // base object for decoration; does not know about its decorators
{
    public function format(string $text): string
    {
        return $text;
    }
}

// "Decorator" - defines an interface that conforms to the "Component"'s interface
abstract class TextDecorator implements TextFormatter // usually is an abstract class
{
    public function __construct(private TextFormatter $textFormatter) {} // a reference to the "Component" object

    public function format(string $text): string
    {
        return $this->textFormatter->format(text: $text); // forwards request to its component
    }
}

// "Concrete Decorators":
class StrongText extends TextDecorator
{
    public function format(string $text): string
    {
        return '<strong>' . parent::format(text: $text) . '</strong>'; // adds a functionality to the component
    }
}

class ParagraphText extends TextDecorator // it is easy to define new, independent kinds of decorators
{
    public function format(string $text): string
    {
        return '<p>' . parent::format(text: $text) . '</p>'; // performs actions before and after forwarding
    }
}

// client code does not know and care whether $textFormatter is a concrete component or its decorated version
function clientCode(TextFormatter $textFormatter, string $text): void
{
    echo $textFormatter->format(text: $text) . PHP_EOL;
}

$plainText = new PlainText();
clientCode(textFormatter: $plainText, text: 'This is an undecorated text.');

$paragraph = new ParagraphText(textFormatter: $plainText); // dynamically adding new functionalities at run-time
$strongWrappingParagraph = new StrongText(textFormatter: $paragraph); // allows nesting decorators
clientCode(textFormatter: $strongWrappingParagraph, text: 'This is a decorated text.');

$decoratedText =
    new ParagraphText( // allows an unlimited number of decorators
        textFormatter: new StrongText(
            textFormatter: new ParagraphText(textFormatter: $plainText) // adding the same decorator again
        )
    );
clientCode(textFormatter: $decoratedText, text: 'This is another decorated text.');