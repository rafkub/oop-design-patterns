# Chain of Responsibility
* chains the receiving objects and pass the request along the chain until an object handles it
* avoids coupling the sender of a request to its receiver by giving more than one
  object a chance to handle the request
* each object on the chain shares a common interface for handling requests and for
  accessing its successor on the chain

## Participants
### "Handler"
* defines an interface for handling requests
* (optional) implements the successor link
  * lets the handler provide a default implementation of handle request
    that forwards the request to the successor

### "Concrete Handler"
* handles requests it is responsible for
* can access its successor
* if the "Concrete Handler" can handle the request, it does so;
  otherwise it forwards the request to its successor or - if there is a default implementation of handle request
  in the "Handler" - it relies on it to forward the request unconditionally

### "Client"
* initiates the request to a "Concrete Handler" object on the chain

## Benefits
* reduced coupling
  * a request is made to one of several objects without specifying the receiver explicitly
  * the receiver and the sender have no explicit knowledge of each other
  * an object in the chain doesn't have to know about the chain's structure
  * instead of objects maintaining references to all candidate receivers,
    they keep a single reference to their successor
* added flexibility in assigning responsibilities to objects
  * the set of objects that can handle a request may be specified dynamically
    * adding to or otherwise changing the chain at run-time
* the handler is ascertained automatically

## Drawbacks
* receipt isn't guaranteed
  * there is no guarantee a request will be handled at all
    * none of the receivers handle the request, and it falls of the end of the chain 
    * incorrect chain configuration

## Variations
### Implementing the successor chain
* define new links
  * in the "Handler", but could be also in the "Concrete Handler"
* use existing links
  * parent references in part-whole hierarchy
### Representing requests
* a hard-coded operation invocation
    * simple, convenient and safe
    * can forward only the fixed set of requests that the "Handler" class defines
* a single handler function that takes a request code as parameter
  * more flexible
  * supports an open-ended set of requests
  * the sender and receiver have to agree on how the request should be encoded
  * requires conditional statements for dispatching the request based on the parameter
  * no type-safety
    * solution: use separate request objects that bundle request parameters (with possible subclassing)
      and use run-time type information or define an accessor that returns an identifier for the class
      to identify the request. The subclass handles only the requests in which it's interested;
      other requests are forwarded to the parent class