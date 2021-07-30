# Decorator
* attaches additional responsibilities to an object dynamically and
  transparently, that is, without affecting other objects
* a flexible alternative to subclassing for extending functionality
* adds responsibilities to individual objects, not to an entire class

## Participants
### "Component"
* defines the interface for objects that can have
  responsibilities added to them dynamically

### "Concrete Component"
* defines an object to which additional responsibilities can be attached

### "Decorator"
* maintains a reference to a "Component" object
* defines an interface that conforms to "Component"'s interface
* simply forwards requests to its component

### "Concrete Decorator"
* adds responsibilities to the component
* forwards requests to the decorated component and
  may perform additional actions before or after forwarding
  
## Benefits

* more flexibility than static inheritance - responsibilities can be added and removed at run-time
* prevents an explosion of subclasses to support every combination
  of numerous independent extensions that are possible
  (inheritance requires creating a new class for each additional responsibility)
* allows nesting decorators recursively, thereby allowing 
  an unlimited number of added responsibilities
* makes it easy to add a property twice
* avoids feature-laden classes high up in the hierarchy
  * makes it easy to define new kinds of "Decorators" independently of
    the classes of objects they extend, even for unforeseen extensions
* the component doesn't have to know anything about its decorators
  * the decorators are transparent to the component

## Drawbacks
* even though a decorator acts as a transparent enclosure, it is not identical to its component
  * do not rely on object identity when using decorators
* lots of little objects that look alike
  * can be hard to learn about the structure and debug
    
## Variations
* omitting the abstract "Decorator" class
  * when only one responsibility needs to be added
    * merge "Decorator"'s responsibility for forwarding requests to the component
      into the "Concrete Decorator"