# Components

## PermissionsComponent

The `PermissionsComponent` is a custom security implementation tailored for Expedite. It is driven by the `requested_urls` database table. That table can be configured using the `Permissions` module, but the enforcement comes from the Expedite Core. It also uses the `User` model from the `User` Module (a requirement for Expedite to work; I didn't want to do it this way, but it ended up being that way because reasons).

### initialize(Controller $controller) 

This method is called by CakePHP on Controller instantiation. It makes `$controller` available to the component. 

### can()

This checks the controllers' `CakeRequest` class for the current controller/action and returns `true` if the logged-in `User` has permission to perform this action or `false` if not. 

### check($controller = null, $action = null)

This method checks that there is a user logged in. It then checks to ensure that the user is active. Then it checks if the user is a superuser: if yes, then return true as superusers always have access. Next, a query is run looking to see if the user is in a group that allows them to access `/$controller/$action`, if it does, then return true. Else, return false.  

### in($group = array())

This method can be passed a list of group IDs, or a single ID. Then it checks if the user is in one of those groups and return true if they are, false if not.

## StackMessagesComponent

The `StackMessagesComponent` is the result of Expedite being able to process multiple forms asynchronously while still being a single action for the user. CakePHP's `MessagesComponent` only stores a single message. This can queue up multiple messages in the session to be displayed to the user on page reload. 

### initialize(Controller $controller)

This method is called by CakePHP on Controller instantiation. It initializes the `StackMessages` array in the session.

### push($message, $type)

Pushes a `$message` onto `StackMessages` with `$type` that can be used to set CSS classes in the view. 

### pop()

`array_pop()`'s a message from `StackMessages`

### flush()

Removes all entries from `StackMessages`, and returns them. 

### destroy()

Removes all entries from `StackMessages`.

### exists()

Checks to see if messages are queued up. 