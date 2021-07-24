# Template Method
* defines the skeleton of an algorithm in an operation, deferring some steps to subclasses
  which provide concrete behavior
* lets subclasses redefine certain steps of an algorithm without changing the algorithm's structure

## Participants
### "Abstract Class"
* defines abstract operations that concrete subclasses define to implement steps of an algorithm
* implements a template method defining the skeleton of an algorithm which calls operations defined in "Abstract Class"

### "Concrete Class"
* implements the operations to carry out subclass-specific steps of the algorithm

## Benefits
* factoring out common behavior which leads to code reuse

## Drawbacks
* some clients may be limited by the provided skeleton of an algorithm