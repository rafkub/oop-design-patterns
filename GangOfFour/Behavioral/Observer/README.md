# Observer
* defines a one-to-many dependency between objects so that when one object changes state,
  all its dependents are notified and updated automatically
  
## Participants
### "Subject"
* provides an interface for attaching and detaching "Observer" objects
* any number of "Observer" objects may observe a subject

NOTE: PHP has a built-in `SplSubject` interface with `attach`, `detach` and `notify` actions

### "Observer"
* defines an updating interface for objects that should be notified
  of changes in a subject

NOTE: PHP has a built-in `SplObserver` interface with `update` action

### "Concrete Subject"
* stores state of interest to "Concrete Observer" objects
* knows its observers and sends a notification to them when its state changes

### "Concrete Observer"
* maintains a reference to a "Concrete Subject" object
* stores state that should stay consistent with the subject's
* implements the "Observer" updating interface to keep its state
  consistent with the subject's
  
## Benefits
* varying subjects and observers independently
* reusing subjects without reusing their observers, and vice versa
* adding observers without modifying the subject or other observers
* abstract (minimal) coupling between "Subject" and "Observer"
* support for broadcast communication

## Drawbacks
* unexpected updates
  * observers have no knowledge of each other's presence 
    and are unaware of the ultimate cost of changing the subject
* simple update protocol provides no details on what changed in the subject
* dangling references to deleted subjects
  (subject should notify its observers as it is deleted 
  so that they can reset their reference to it)
  
## Variations
* push model - the subject sends observers detailed information about the change
  (observers are less reusable, because subject makes assumptions about them)
* pull model - the subject sends minimal notification, and observers ask for details explicitly
  (they must ascertain what changed without help from the subject)
* triggering the `update` operation
  * state-setting operations on subject call `notify` after they change the subject's state
    (clients don't have to remember to call `notify` on the subject
    but several consecutive operations will cause several consecutive updates,
    which may be inefficient)
  * clients responsible for calling `notify`
    (client can wait to trigger the update until after a series of state changes has been made,
    but it has an added responsibility to trigger the update, which might be forgotten)
* mapping subjects to their observers
  * subject stores references to observers (when few subjects and many observers)
  * associative look-up (when many subjects and few observers)
* observing more than one subject
  * extend the Update interface (subject passed as a parameter in the `update`
    operation) to let the observer know which subject is sending the notification
* sending notifications from template methods (the last operation) in abstract subject classes
  to make sure subject state is self-consistent before notification is being sent
* specifying modifications of interest explicitly
  * extending the subject's registration interface 
    to allow registering observers only for specific events
* ChangeManager - encapsulating complex update semantics
  (when the dependency relationship between subjects and observers is complex)
  * eliminates the need for subjects to maintain references to their observers and vice versa,
    defines a particular update strategy, updates all dependent observers at the request of a subject