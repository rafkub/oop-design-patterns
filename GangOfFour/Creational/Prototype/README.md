# Prototype
* specify the kinds of objects to create using a prototypical instance,
  and create new objects by copying (or "cloning") this prototype
* cloning a prototype is similar to instantiating a class
* delegates the cloning process to the actual objects that are being cloned

## Participants
### "Prototype"
* declares an interface for cloning itself

### "Concrete Prototype"
* implements an operation for cloning itself
* if it is a subclass, it must call the parent's cloning method first

### "Client"
* creates a new object by asking a prototype to clone itself

## "Prototype manager" (optional)
* an associative registry which stores all available prototypes for clients to clone from
  * provides an easy way to access frequently-used prototypes
  * returns the prototype matching a given key
  * operations for registering and unregistering a prototype

## Benefits:
* hides the concrete product classes from the client,
  thus reducing the number of names clients know about
* lets a client work with application-specific classes without modification
* adding and removing products at run-time
* specifying new objects by varying values
  * a client can exhibit new behavior by delegating responsibility to the prototype
  * lets users define new "classes" without programming
  * can greatly reduce the number of classes a system needs
* specifying new objects by varying structure
  * the composite object should implement clone operation as a deep copy
* reduced subclassing
  * pre-built prototypes can be an alternative to subclassing
* configuring an application with classes dynamically

## Drawbacks:
* each subclass of Prototype must implement the clone operation, which may be difficult
  when internals include objects that don't support copying or have circular references
  
## NOTE:
Prototype is particularly useful with static languages, 
where little or no type information is available at run-time. It's less important in PHP
which comes with the built-in `clone` keyword. (performs shallow copy)
If a deep copy is required or any properties need to be changed, `__clone()` magic method might be implemented.
This approach is also simpler to implement.
Hence, "Prototype" interface is not needed in PHP. (see [without-prototype.php](without-prototype.php))

Additionally, to check whether a class is cloneable or not (a class does not need to implement `__clone()` 
to be cloneable), `ReflectionClass::isCLoneable()` can be used.
However, the most reliable method is to catch exception thrown by `clone`.