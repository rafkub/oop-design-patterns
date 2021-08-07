# Bridge
* decouples an abstraction from its implementation so that the two can vary independently
* an abstraction can have one of several possible implementations
* puts the abstraction and its implementation in separate class hierarchies
* an alternative to inheritance

## Participants
### "Abstraction"
* defines the abstraction's interface
* maintains a reference to an object of type "Implementor"
* typically, defines higher-level operations based on primitives in "Implementor"

### "Refined Abstraction"
* extends the interface defined by "Abstraction"

### "Implementor"
* defines the interface for implementation classes
  * it doesn't have to correspond to "Abstraction"'s interface
  * typically, provides only primitive operations

### "Concrete Implementor"
* implements the "Implementor" interface and defines its concrete implementation

## Benefits
* easy to modify, extend, and reuse abstractions and implementations independently
* implementation can be selected or switched at run-time
* both the abstractions and their implementations can be extensible by subclassing
* hiding implementation details from clients
  * changes in the implementation of an abstraction have no impact on clients
* avoids a proliferation of classes
* it is possible to share an implementation among multiple objects
* client code can instantiate an object without mentioning specific implementation
* encourages layering that can lead to a better-structured system
  * the high-level part of a system only has to know about "Abstraction" and "Implementor"

## Drawbacks
* increases design complexity

## Variations
* only one "Implementor"
  * creating an abstract "Implementor" class isn't necessary
  * a degenerate case of the Bridge pattern
* creating the right "Implementor" object
  * in "Abstraction"'s constructor
    * "Abstraction" knows about all "Concrete Implementor" classes 
      and decides between them based on parameters passed to its constructor
  * a default implementation initially and changed later according to needs
  * delegating to [Abstract Factory](../../Creational/AbstractFactory)
    * "Abstraction" is not coupled directly to any of the "Implementor" classes