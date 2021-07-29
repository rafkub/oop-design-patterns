# Command
* encapsulates a request as an object, thereby allowing to parameterize clients with
  different requests, queue or log requests, and support undoable operations
* object-oriented replacement for callback
  
## Participants
### "Command"
* declares an interface for executing an operation: 
  * required:
    * `execute` operation
  * optional:
    * `unexecute`/`undo` for undo support
    * `load` and `store` for logging support

### "Concrete Command"
* defines a binding between a "Receiver" object and an action
  (stores the receiver as an instance variable)
* implements `execute` by invoking the corresponding operation(s) on "Receiver"

### "Client"
* creates a "Concrete Command" object and sets its receiver

### "Invoker"
* asks the command to carry out the request

### "Receiver"
* knows how to perform the operations associated with carrying out a request
* any class may serve as a "Receiver"

## Benefits
* decouples the object that invokes the operation 
  from the one having the knowledge to perform it
* commands are first-class objects (they can appear in an expression, be assigned to a variable, be used as an argument,
  and be returned by a function call) - they can be manipulated and extended
* allows replacing commands dynamically
* supports assembling commands into a composite command (macro commands)
* easy to add new commands
* supports undo and redo
  * one level 
    * stores only the command that was executed last
  * multiple-level
    * maintaining history list of commands - possibly copies of the commands should be placed on the history list 

## Drawbacks
None

## Variations
* intelligent command
  * implements the actions itself without delegating to a receiver
* delegating command
  * defines only a binding between a receiver and the actions that carry out the request