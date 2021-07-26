<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Behavioral\WithoutIterator;

class Collection
{
    public function __construct(private array $elements = []) {}

    public function getElements(): array
    {
        return $this->elements;
    }
}

$collection = new Collection([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]);
// Custom iteration over collection is not encapsulated and has to be repeated each time:
foreach ($collection->getElements() as $key => $element) {
    if ($key % 2 === 1) { // processing only odd elements of the collection
        echo $element . ' ';
    }
}
echo PHP_EOL;