# Iterator
* provides a way to access the elements of an aggregate object sequentially without
exposing its underlying representation
  
## Participants
### "Iterator"
* defines an interface for accessing and traversing elements
* the minimal interface to "Iterator" consists of the operations:
  first, next, isDone, and currentItem
* possible additional operations: previous, skipTo

NOTE: PHP has a built-in Iterator interface:

"Iterator" operation | PHP Iterator interface
| --- | --- |
first | rewind()
next | next()
isDone | valid()
currentItem | current()
- | key()

### "Concrete Iterator"
* implements the "Iterator" interface
* keeps track of the current position in the traversal of the aggregate

### "Aggregate"
* defines an interface for creating an "Iterator" object

NOTE: PHP has a built-in IteratorAggregate interface

### "Concrete Aggregate"
* implements the "Iterator" creation interface to return an instance
  of the proper "Concrete Iterator"
  
## Benefits
* variations in the traversal of an aggregate
* simplified Aggregate's interface
* multiple traversals can be pending on an aggregate

NOTE: In PHP `foreach` loop can be used to iterate over objects implementing 
Iterator or IteratorAggregate interface

## Variations
* external
  * more flexible
  * client defines and controls the iteration logic
    * must advance the traversal and request the next element explicitly
* internal iterator
  * easier to use
  * iterator defines and controls the iteration logic
    * iterator applies operation handed by client to every element in the aggregate
* cursor
  * the aggregate defines the traversal algorithm and 
    uses the iterator to store just the state of the iteration
* robust iterator
  * ensures that insertions and removals won't interfere with traversal
    (without copying an aggregate)
* NullIterator
  * may be returned by leaf elements of a tree-structured aggregate 
    to make traversing easier and in a uniform way. 