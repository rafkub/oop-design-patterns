<?php

declare(strict_types=1);

namespace OOP\DesignPatterns\GangOfFour\Creational\Prototype;

use DateTime;

// "Prototype"
interface Cloneable
{
    function clone(): self;
}

// "Concrete Prototype"
class Book implements Cloneable
{
    public function __construct(private string $title, private Author $author, private DateTime $publishedIn) {}

    // PHP does not support constructor overloading:
    // public function __construct(self $book)
    // {
    //      $this->title = $book->title;
    //      $this->author = $book->author; // shallow copy
    //
    //      // Creating a deep copy of publishedIn property:
    //      $publishedIn = new DateTime();
    //      $publishedIn->setDate(year: (int)$this->publishedIn->format('Y'), month: 1, day: 1);
    //      $this->publishedIn = $publishedIn;
    // }
    //
    // public function clone(): self
    // {
    //     return new self($this);
    // }
    //
    // Instead:
    public function clone(): self
    {
        $copy = new self($this->title, $this->author, $this->publishedIn); // shallow copy of author and publishedIn

        // Creating a deep copy of publishedIn property:
        $publishedIn = new DateTime();
        $publishedIn->setDate(year: (int)$this->publishedIn->format('Y'), month: 1, day: 1);
        $copy->publishedIn = $publishedIn;

        return $copy;
    }

    public function setPublishedIn(DateTime $publishedIn): void
    {
        $this->publishedIn->setDate(year: (int)$publishedIn->format('Y'), month: 1, day: 1);
    }

    public function __toString(): string
    {
        return "$this->title by {$this->author->getName()}, published in {$this->publishedIn->format('Y')}.";
    }
}

class Author
{
    public function __construct(private string $name) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}

$author = new Author(name: 'Miguel de Cervantes');
$publishedIn = new DateTime();
$publishedIn->setDate(year: 1605, month: 1, day: 1);
$book = new Book(title: 'Don Quixote', author: $author, publishedIn: $publishedIn);

$newBook = $book->clone(); // creates a new object by asking a prototype to clone itself

$author->setName(name: 'M. de Cervantes'); // same Author object is used in both books (shallow copy)

// NOTE: clone is necessary here because setDate() would modify the object used by the original book
$newBook->setPublishedIn(publishedIn: (clone $publishedIn)->setDate(year: 1615, month: 1, day: 1));
// Another option would be to create a new object and use it instead:
// $newPublishedIn = new DateTime();
// $newBook->setPublishedIn(publishedIn: $newPublishedIn->setDate(year: 1615, month: 1, day: 1));

echo $book . PHP_EOL;
echo $newBook . PHP_EOL;