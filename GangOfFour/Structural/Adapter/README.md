# Adapter
* converts the interface of a class into another interface clients expect
* lets classes work together that couldn't otherwise because of incompatible interfaces
* often is responsible for functionality the adapted class doesn't provide

## Participants
### "Target"
* defines the domain-specific interface that "Client" uses

### "Client"
* collaborates with objects conforming to the "Target" interface

### "Adaptee"
* defines an existing interface that needs adapting

### "Adapter"
* adapts the interface of "Adaptee" to the "Target" interface

## Benefits
* lets a single Adapter work with many "Adaptees" (its subclasses)
* can add functionality to all "Adaptees" at once

## Drawbacks
* harder to override "Adaptee" behavior

## Variations
* object version (described above)
    * relies on object composition
    * more flexible than class adapter
    * requires a little more effort to write
* class version
  * uses multiple inheritance (not possible in PHP)
    * lets "Adapter" override some of "Adaptee"'s behavior, since "Adapter" is a subclass of "Adaptee"
    * introduces only one object
    * not possible to adapt a class and all its subclasses
      (adapts "Adaptee" to "Target" by committing to a concrete "Adapter" class)
* two-way adapters
  * uses multiple inheritance (not possible in PHP)
  * provides transparency - useful when two different clients need to view an object differently
    * conforms to the "Adaptee" interface, so it can be used as is wherever an "Adaptee" object can

## Alternatives
### Pluggable adapter
* classes with built-in interface adaptation
  * minimizing the assumptions other classes must make to use it
  * solutions:
    * using abstract operations for the smallest subset of operations that do the adaptation
      and letting subclasses implement the abstract operations
    * using delegate objects to use a different adaptation strategy by substituting a different delegate
    * using parameterized adapters