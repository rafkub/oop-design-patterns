# Simple Factory

* encapsulates object creation

Sometimes referred to as a programming idiom rather than a full-fledged design pattern.

## Static Factory variant
* define create() method in Simple Factory as static

### Benefits
* no need to instantiate an object to make use of the create() method
### Drawbacks
* it is not possible to change the behavior of the create() method by subclassing Static Factory