# Builder
* separate the construction of a complex object from its representation so that
  the same construction process can create different representations
  
## Participants
### "Builder"
* specifies an abstract interface for creating parts of a "Product" object

### "Concrete Builder"
* constructs and assembles parts of the product by implementing the "Builder" interface
* defines and keeps track of the representation it creates
* provides an interface for retrieving the product

### "Director" (optional)
* constructs an object using the Builder interface

### "Product"
* represents the complex object under construction

## Benefits
* the algorithm for creating a complex object is independent of the
  parts that make up the object and how they're assembled
* allows to vary a product's internal representation
* isolates code for construction and representation
* finer control over the construction process
  * the product is constructed step by step under the director's control
    
## Drawbacks
* increased complexity due to multiple new classes