# Singleton

* restricts object creation for a class to only one instance

> _[Singleton] is useful when exactly one object is needed to coordinate actions across the system._ - Wikipedia

NOTE:

Nowadays it is considered an anti-pattern because it:
* violates the 
[Single Responsibility Principle](https://github.com/rafkub/oop-principles/tree/main/SOLID/SingleResponsibility)
  - a class has its main, business responsibility and a new responsibility of restricting its instantiation
* promotes tight coupling
  - the reference to the singleton cannot be changed according to the environment
  - no way to use polymorphism to substitute an alternative 
* introduces global state into an application
  - carries state as long as the program lasts 
  - dependencies are hidden instead of being explicit
  - makes TDD virtually impossible
* complicates multithreading
  - race condition when checking if the singleton has been instantiated

