# Active Record pattern
* an object carries both data and behavior
  * the interface of an object includes functions such as insert, update, and delete,
  plus properties that correspond to the columns in the underlying database table
* a class corresponds to a database table or view
* an object corresponds to a single row in the table

## NOTE:
Currently, it is sometimes considered as an anti-pattern because it
violates the Single Responsibility Principle and is not easily testable.

## Implementation example
* Eloquent (used in the Laravel framework)