# Facade
* provide a unified interface to a set of interfaces in a subsystem
* Facade defines a higher-level interface that makes the subsystem easier to use
* simplify the interface for the common case

## Participants
### "Facade"
* knows which subsystem classes are responsible for a request
* delegates client requests to appropriate subsystem objects

### "subsystem classes" 
* implement subsystem functionality
* handle work assigned by the Facade object
* have no knowledge of the facade; that is, they keep no references to it

## Benefits:
* It shields clients from subsystem components, thereby reducing the number of objects that clients deal with
  and making the subsystem easier to use
* It promotes weak coupling between the subsystem and its clients
* It doesn't prevent applications from using subsystem classes if they need to
  * choice between ease of use and generality

## Drawbacks:
* None