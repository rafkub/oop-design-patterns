# Proxy
* provides a surrogate or placeholder for another object to control access to it
* acts as a stand-in for the real object
* acts just like the original object and takes care of instantiating it when required

## Participants
### "Proxy"
* maintains a reference that lets the proxy access the real subject
* provides an interface identical to Subject's so that a proxy can
  by substituted for the real subject
* controls access to the real subject and may be responsible for
  creating and deleting it

### "Subject"
* defines the common interface for "Real Subject" and "Proxy" so that a
"Proxy" can be used anywhere a "Real Subject" is expected
  
### "Real Subject"
* defines the real object that the proxy represents

## Types
* remote proxy
    * provides a local representative for an object in a different address space
* virtual proxy
    * creates expensive objects on demand
* protection proxy
    * controls access to the original object
* smart reference
    * performs additional actions when an object is accessed
    
## Benefits
* a remote proxy can hide the fact that an object resides in a different address space
* a virtual proxy can perform optimizations such as creating an object on demand
* both protection proxies and smart references allow additional housekeeping
  tasks when an object is accessed

## Drawbacks
None