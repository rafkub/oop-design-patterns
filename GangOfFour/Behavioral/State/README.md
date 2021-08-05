# State
* allows an object to alter its behavior at run-time when its internal state changes
* the object appears to change its class

## Participants
### "Context"
* defines the interface of interest to clients
* maintains an instance of a "Concrete State" subclass that defines the current state
* delegates state-specific requests to the current "Concrete State" object
* may pass itself as an argument to the "State" object handling the
  request; this lets the "State" object access the context if necessary

### "State"
* defines an interface for encapsulating the behavior associated with
  a particular state of the "Context"

### "Concrete State"
* each subclass implements a behavior associated with a state of the "Context"

## Benefits
* localizes state-specific behavior and partitions behavior for different states
  * puts all behavior associated with a particular state into one object
* new states and transitions can be added easily by defining new subclasses
* especially useful if there are many states - avoids many large conditional statements
* makes state transitions explicit
* protects the "Context" from inconsistent internal states
  * transitions are atomic due to rebinding only one variable - the "Context"'s state object variable
* state objects can be shared
  * when the state they represent is encoded entirely in their type, i.e. they have no instance variables

## Drawbacks
* less compact than a single class

## Variations
* "Context" decides which state succeeds another and under what circumstances
  * when the criteria are fixed
* "Concrete State" decides which state succeeds another and under what circumstances 
  * decentralized, more flexible approach
    * easy to modify or extend the logic by defining new "State" subclasses
    * introduces implementation dependencies between subclasses 
      (one "State" subclass has knowledge of at least one other)
  * requires adding an interface to the "Context" that lets
    state objects set the "Context"'s current state explicitly
* creating state objects only when they are needed and destroying them thereafter
  * when the states that will be entered aren't known at run-time, and contexts change state infrequently
* creating state objects ahead of time and never destroying them
  * when state changes occur rapidly - to avoid destroying states, because they may be needed again shortly
  * instantiation costs are paid once up-front, and there are no destruction costs
  * inconvenient, because the "Context" must keep references to all states that might be entered