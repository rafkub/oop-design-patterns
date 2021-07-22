# Dependency Injection

* implementation technique for populating instance variables of a class 
* design pattern based around the principle of Inversion of Control (IoC)
  to ensure that a class has no involvement or awareness in the creation or lifetime of objects
* a class defers responsibility of obtaining or providing its own dependencies to external code
  (manual injector, factories, service locator, framework or IoC container)

> _[D]ependency injection is a technique in which an object receives other objects that it depends on._ - Wikipedia

## Note:

There are different ways to inject dependencies:
- constructor injection
  - The dependencies are provided through a client's class constructor.
- method/setter injection
  - The client exposes a setter method that the injector uses to inject the dependency.
- property/field injection
  - The dependencies are provided through a client's properties.
- interface injection
  - The dependency's interface provides an injector method that will inject the dependency into any client passed to it.
  Clients must implement an interface that exposes a setter method that accepts the dependency.