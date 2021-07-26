<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Behavioral\Iterator;

use Iterator;
use IteratorAggregate;

class OddCollection implements IteratorAggregate
{
    public function __construct(private array $elements = []) {}

    public function getElements(): array
    {
        return $this->elements;
    }

    public function getIterator(): OddIterator // used implicitly by foreach
    {
        return new OddIterator(collection: $this);
    }
}

// Iteration is encapsulated in a separate class:
class OddIterator implements Iterator
{
    private int $position = 0;

    public function __construct(private OddCollection $collection) {}

    public function current(): mixed
    {
        return $this->collection->getElements()[$this->position];
    }

    public function next(): void
    {
        $this->position += 2;
    }

    public function key(): int
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return isset($this->collection->getElements()[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 1;
    }
}

$oddCollection = new OddCollection(elements: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]);
// Simple usage:
foreach ($oddCollection as $element) {
    echo $element . ' ';
}
echo PHP_EOL;