# Null Object

* object with no referenced value or with defined neutral ("null") behavior

> _Instead of using a null reference to convey absence of an object (for instance, a non-existent customer), 
> one uses an object which implements the expected interface, but whose method body is empty._ - Wikipedia

## NOTE:
As of PHP 8.0, the null safe operator is often simpler and better alternative to the Null Object design pattern.