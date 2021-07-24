<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Behavioral\TemplateMethod;

// "Abstract Class":
abstract class FileMinifier
{
    public function minify(string $fileName): void // template method defines the skeleton of an algorithm
    {
        $this->readFile($fileName);
        $this->removeNewLines();
        $this->removeWhitespaces();
        $this->removeComments();
        $this->shortenContent();
        $this->closeFile($fileName);
    }

    protected function readFile(string $fileName): void // default implementation; subclasses do not need to override it
    {
        echo "Reading content of the $fileName file..." . PHP_EOL;
    }

    protected function removeNewLines(): void
    {
        echo 'Removing new lines...' . PHP_EOL;
    }

    protected function removeWhitespaces(): void // a hook - default implementation does nothing
    {
    }

    protected function removeComments(): void
    {
        echo "Removing block comments (/* comment */)..." . PHP_EOL;
    }

    abstract protected function shortenContent(): void; // needs to be implemented by subclasses

    protected function closeFile(string $fileName): void
    {
        echo "Closing $fileName file..." . PHP_EOL;
    }
}

// "Concrete Classes":
class CssMinifier extends FileMinifier
{
    // subclass-specific implementation of the algorithm steps
    protected function removeWhitespaces(): void // hook implementation
    {
        echo "Removing white spaces apart from when it delimits CSS token or in strings..." . PHP_EOL;
    }

    protected function shortenContent(): void // required implementation
    {
        // nothing can be done here
    }
}

class JsMinifier extends FileMinifier
{
    protected function removeNewLines(): void // redefining the algorithm step
    {
        echo 'Removing new lines and adding missing semicolons...' . PHP_EOL;
    }

    protected function removeWhitespaces(): void
    {
        echo "Removing white spaces apart from when in strings..." . PHP_EOL;
    }

    protected function removeComments(): void
    {
        parent::removeComments(); // reusing a default implementation
        echo "Removing line comments (// comment )..." . PHP_EOL; // additional action
    }

    protected function shortenContent(): void
    {
        echo "Shortening function parameters and local symbols..." . PHP_EOL;
        echo "Removing unnecessary block delimiters..." . PHP_EOL;
        echo "Removing semicolons preceding a right curly brace..." . PHP_EOL;
        echo "Optimizations within expressions and functions..." . PHP_EOL;
    }
}

class HtmlMinifier extends FileMinifier
{
    protected function removeWhitespaces(): void
    {
        echo "Removing white spaces apart from when inside text..." . PHP_EOL;
        echo "Substituting subsequent white spaces in text with one character..." . PHP_EOL;
    }

    protected function removeComments(): void // substitutes a default implementation
    {
        echo "Removing block comments (<!-- comment -->)..." . PHP_EOL;
    }

    protected function shortenContent(): void
    {
        echo "Stripping quotes..." . PHP_EOL;
        echo "Minimizing inline CSS..." . PHP_EOL;
        echo "Minimizing inline JavaScript..." . PHP_EOL;
    }
}

$css = new CssMinifier();
$css->minify('styles.css');
echo PHP_EOL;

$js = new JsMinifier();
$js->minify('script.js');
echo PHP_EOL;

$html = new HtmlMinifier();
$html->minify('index.html');