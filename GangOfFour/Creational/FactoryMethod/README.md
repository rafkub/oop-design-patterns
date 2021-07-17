# Factory Method
* define an interface for creating an object, but let subclasses decide which class
to instantiate
* Factory Method lets a class defer instantiation to subclasses

## Participants
### "Product"
* defines the interface of objects the factory method creates

### "Concrete Product"
* implements the Product interface

### "Creator"
* declares the factory method, which returns an object of type Product
* Creator may also define a default implementation of the factory
  method that returns a default ConcreteProduct object
* may call the factory method to create a Product object

### "Concrete Creator"
* overrides the factory method to return an instance of a "Concrete Product"

## Benefits:
* eliminates the need to bind application-specific classes into code; it can work with
  any user-defined "Concrete Product" classes
* more flexible than creating an object directly
* gives subclasses a hook for providing an extended version of an object
* connects ((at least partially)) parallel class hierarchies

## Drawbacks:
* clients might have to subclass the "Creator" class just to create a particular "Concrete Product" object

# Variants:
* "Creator" class is an abstract class and does not provide an implementation for the factory method it declares
  * when there is no reasonable default it allows to instantiate unforeseeable classes
* "Creator" is a concrete class and provides a default implementation for the factory method
  * subclasses can override default implementation if required
* "Creator" is an abstract class that defines a default implementation
* Parameterized factory methods
  * factory method creates multiple kinds of products based on a parameter that identifies the kind of object to create