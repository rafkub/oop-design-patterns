# Composite
* composes objects into tree structures to represent part-whole hierarchies
* lets clients treat individual objects and compositions of objects uniformly

## Participants
### "Component"
* abstract class that represents both primitives and their containers
  * declares the interface for objects in the composition
  * declares operations for primitives
* implements default behavior for the interface common to all classes,
  as appropriate
* declares an interface for accessing and managing its child
  components (required: `add`, optional: `remove`, `getChild`)
* (optional) defines an interface for accessing a component's parent
  in the recursive structure, and implements it if that's appropriate

### "Leaf" - a primitive
* represents leaf objects in the composition
* has no children, so it does not implement child-related operations
* subclasses "Component" and implements own business logic for primitive operations

### "Composite" - an aggregate
* defines behavior for components having children
  * implements child-related operations in the "Component" interface
* stores child components
* can compose other aggregates as well
* implements "Component" to call operations of its children

### "Client"
* manipulates objects in the composition through the "Component" interface

## Benefits
* simplified client's code
  * it does not know or care whether it is dealing with a leaf or a composite component 
* primitive objects can be composed into more complex objects recursively
* makes it easier to add new kinds of components ("Composite" and "Leaf")
  * they work automatically with existing structures and client code

## Drawbacks
* can make a design overly general
  * makes it harder to restrict the components of a composite - type run-time checks are needed

## Variations
* explicit parent references
  * simplified the traversal (moving up) and management (deleting a component) of a composite structure
  * helps supporting the Chain of Responsibility pattern
  * usual place to define the parent reference and the operations that manage it is in the Component class
  * all children of a composite should have as their parent the composite that has them as children
    * change a component's parent only when it's being added or removed from a composite
* sharing components
  * to reduce storage requirements
* defining the child management interface in the "Component"
  * gives transparency because all components can be treated uniformly
  * costs safety, because clients may try to add and remove objects from leaves
    * `add` and `remove` should fail by default, i.e. raise an exception
      if the component isn't allowed to have children or
      if the argument of `remove` isn't a child of the component, respectively
* defining the child management interface in the "Composite"
  * gives safety, because it is not possible to add or remove objects from leaves
  * costs transparency, because leaves and composites have different interfaces
    * a need for differentiation of types before taking the appropriate action
* "Component" implements a list of "Components"
  * worthwhile only if there are relatively few children in the structure, because
    it incurs a space penalty for every leaf, even though a leaf never has children
* ordered list of children
  * use Iterator pattern
* caching to improve performance
  * the "Composite" class can cache traversal or search information about its children
  * changes to a component requires invalidating the caches of its parents - 
    define an interface for telling composites that their caches are invalid

## NOTE:
PHP allows improving implementation of the classic design 
as is illustrated in [improved-composite.php](improved-composite.php).