# Data Mapper
* separates the in-memory objects from the database keeping them independent
* is responsible for transferring data between objects and the storage
* objects have no knowledge of the database schema and even the database itself

## NOTE:
It conforms to the Single Responsibility principle and objects are easily testable.

## Implementation example
Doctrine 2 (used in the Symfony framework)