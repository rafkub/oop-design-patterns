# Memento
* without violating encapsulation, captures and externalizes an object's internal
  state so that the object can be restored to this state later

## Participants
### "Memento"
* records the internal state (full or partial) of "Originator" object
* protects against access by objects other than the originator
  * has two interfaces:
    * "Caretaker" sees a narrow interface — it can only pass the memento to other objects
    * "Originator" sees a wide interface which lets it
      access all the data necessary to restore itself to its previous state
      * ideally, only the originator that produced the memento is permitted to access the memento's internal state

  NOTE: In PHP there are neither friend functions nor internal classes which are usually used to accomplish that;
        see [memento.php](memento.php) for a work-around
* is passive - only the originator that created a memento assigns or retrieves its state

### "Originator"
* object which state is being recorded
* initializes the memento with information that characterizes its current state
* uses the memento to restore its internal state

### "Caretaker"
* responsible for the memento's safekeeping
* never operates on or examines the contents of a memento

## Benefits
* preserving encapsulation boundaries
  * avoids exposing information that only an originator should manage
* simplifying "Originator"
  * avoids putting all the storage management burden on "Originator"

## Drawbacks
* might be expensive
  * might incur considerable overhead if "Originator" must copy large amounts of information
    or if clients create and return mementos to the originator often
* defining narrow and wide interfaces
  * it may be difficult in some languages (like PHP) to ensure that only the originator can access the memento's state
* hidden costs in caring for mementos
  * caretaker might incur large storage costs not knowing how much state is in the memento
    and being responsible for deleting them

## Variations
* storing only incremental changes
  * when mementos get created and passed back to their originator in a predictable sequence