# Abstract Factory
* provides an interface for creating families of related or dependent objects without
specifying their concrete classes

## Participants
### "Abstract Product"
* declares an interface for a type of product object

### "Concrete Product"
* implements the "Abstract Product" interface

### "Abstract Factory"
* declares an interface for operations that create abstract product objects
* defers creation of product objects to its "Concrete Factory" subclass

### "Concrete Factory"
* implements the operations to create concrete product objects
* usually a single instance is created at run-time

### "Client"
* uses only interfaces declared by "Abstract Factory" and "Abstract Product" classes

## Benefits:
* isolates concrete classes
  * isolates clients from implementation classes
* makes exchanging product families easy
  * one place of change, where a "Concrete Factory" is instantiated
* promotes consistency among products

## Drawbacks:
* supporting new kinds of products is difficult
  * requires extending the factory interface,
    which involves changing the "Abstract Factory" class and all of its subclasses

# Variants:
* "Abstract Factory" classes are often implemented with factory methods
* "Abstract Factory" classes can also be implemented using Prototype