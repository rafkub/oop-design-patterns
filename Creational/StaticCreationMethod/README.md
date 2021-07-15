# Static Creation Method
* is a variant of Creation Method
* possible alternative for the constructor
  
## Benefits (in addition to Creation Method benefits)
* does not require instantiating object with a constructor first
* isolates client from changes to the constructor
* possibility of returning existing objects instead of creating new ones (caching, performance)

## Drawbacks
* it is not possible to change the behavior of the creation method by subclassing