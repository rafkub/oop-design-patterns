# Strategy

* define a family of algorithms, encapsulate each one, and make them interchangeable
* Strategy lets the algorithm vary independently from clients that use it

## Participants
### "Strategy" 
* declares an interface common to all supported algorithms
* "Context" uses this interface to call the algorithm defined by a ConcreteStrategy
### "ConcreteStrategy"
* implements the algorithm using the "Strategy" interface
### "Context"
* is configured with a "ConcreteStrategy" object
* maintains a reference to a "Strategy" object
* may define an interface that lets "Strategy" access its data

## Benefits:
* Families of related algorithms
  * inheritance can help factor out common functionality of the strategies
* An alternative to subclassing
  * avoids hard-wiring the behavior
* Strategies eliminate conditional statements
  * an alternative to conditional statements for selecting desired behavior
* A choice of different implementations of the same behavior
    
## Drawbacks:
* Clients must be aware of different "ConcreteStrategies"
  * Clients might be exposed to implementation issues
* Communication overhead between "Strategy" and "Context"
  * The "Strategy" interface is shared by all "ConcreteStrategy" classes
    whether the algorithms they implement are trivial or complex
* Increased number of objects in an application