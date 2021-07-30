<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Structural\WithoutDecorator;

class TextElement // base object
{
    public function format(string $text): string
    {
        return $text;
    }
}

// New functionalities are statically defined as a hierarchy of classes (functionalities depend on each other):
class ParagraphText extends TextElement
{
    public function format(string $text): string
    {
        return '<p>' . parent::format(text: $text) . '</p>'; // adds a functionality to the component
    }
}

class StrongWrappingParagraphText extends ParagraphText // a new class for each used combination is required
{
    public function format(string $text): string
    {
        return '<strong>' . parent::format(text: $text) . '</strong>'; // performs actions before and after forwarding
    }
}

class ParagraphWrappingStrongWrappingParagraphText extends StrongWrappingParagraphText
{
    public function format(string $text): string
    {
        return '<p>' . parent::format(text: $text) . '</p>';
    }
}

// Other possible combinations may include:
// StrongText, ParagraphWrappingStrongText, StrongWrappingStrongText, StrongWrappingParagraphWrappingStrongText etc.
// which leads to an explosion of subclasses.

// client code does not know or care of which exactly subclass $textElement is
function clientCode(TextElement $textElement, string $text): void
{
    echo $textElement->format(text: $text) . PHP_EOL;
}

// Only hard-coded classes - with predefined combinations - can be used:
clientCode(textElement: new TextElement(), text: 'This is an undecorated text.');
clientCode(textElement: new StrongWrappingParagraphText(), text: 'This is a decorated text.');
clientCode(textElement: new ParagraphWrappingStrongWrappingParagraphText(), text: 'This is another decorated text.');