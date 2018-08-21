# Controllers

## Overview

Expedite builds upon CakePHP's Model-View-Controller (MVC) architecture by implementing a few abstract classes that can be extended by modules in order to perform basic operations. These controllers are largely AJAX-driven, to allow for asynchronous communication and is also driven by the _PermissionsComponent_.

## AppController & PagesController

Please refer to the _CakePHP v2.x_ documentation for more information on these controllers, and what they do. The following abstract controllers extend the _AppController_ as a base class and follow all it's rules with the exception of the logic specific to them.

## ExpeditePluginController

### Overview

The _ExpeditePluginController_ class is built to present a full page to the user, and represents the primary model of the Module (A CakePHP Plugin, thus the name) and is used to call in (or contain) the child models so that a single, modular page can be generated. Every module gets its name from its primary model, whose controller extends this class.

The Controller also allows for creating, updating, and deleting entries from the database but only for the primary model. For updating child models, you will need to make calls to it's own controller.

### Display()

This function is taken _verbatim_ from the _PagesController_. While it would be simpler to just wrap `PagesController::Display();`, it makes it easier to have these called from the top of the module and is purely for semantics. Plus the _PagesController_ was going to be deleted, but is needed for some of CakePHP's functionality to work properly.

### Index($status = 1, $show = 10, $search = '')

This method is quite simple. It's meant to be the base for child methods to extend or call using `return parent::index($status, $show, $search);` however, it can be completely replaced. It returns an array of primary model entries that can be iterated over to create a list, or an _index_.

### view($id = null)

View is the method used to display a primary model entry and all of its attached child model entries. This method is usually extended to set things like dropdown choices for related models, or for custom logic involving user interaction. The basic flow is that the method checks if the `$id` exists in the database model, then checks if the call is AJAX and if so, update the database using POST data. Else, it just grabs the data structure and passes it to the View. The method also checks if the user has proper permissions to perform operations using the `PermissionsComponent`.

### add()

This method is extremely simple. If a user access this URL, it must be over AJAX else it will throw an exception. Over AJAX, a small HTML form is delivered that can be rendered on the current page (To prevent users from losing their place). Once POST, the method checks permissions and then updates the database accordingly.

## delete($id = null)

This method is straightforward. Find an entry with an id = `$id` and delete it and its children from the database. This can only be done through AJAX and the logged-in user must have permission to do so, else and exception will be thrown.

## edit()

This method is disabled by default, but can be overridden by child classes. It is disabled because semantically view/add perform the same actions with less overhead.

## ExpediteHasManyPropertyController

By default, this controller communicates completely via AJAX. All methods, aside from `index()`, are protected by the `PermissionsComponent`.

### $parentModule

By default, this should be set to the ClassName of module's primary model. However, it does not have to be. Any model that relies on a parent: ex. `UserGroup` relies on `User` can use it's parent even if its not the primary model in the module.

### index($parent_id = null)

This method will build a list of model entries with CakePHP's default associations provided a `$parent_id` which is the primary key (index) of this model's `$parentModule`.

### view()

This method is not used by default, but can be overriden.

### add($parent_id = null)

This method takes one parameter, `$parent_id`, which is the primary key of the `$parentModule` model. It will then prompt via ajax a view which contains a form. This form is then submitted and the entry is saved with the parent association.

### edit($id = null)

This method takes the primary key of the model as the `$id` parameter. It then prompts with a view that contains an HTML form for editing the information. POST'ing back to this method will update the information if it is valid.

### delete($id = null)

Straightforward, this method will delete the entry with primary key `$id` if permission is granted to the user.

## ExpediteHasOnePropertyController

This controller extends `ExpediteHasManyPropertyController`, so it uses most of the same methods and properties.

### add($parent_id = null)

This method is disabled for this controller, as normally these types of models have their forms embedded into the view for the `$parentModule`.

### edit($parent_id = null)

This method takes the primary key of the model as the `$id` parameter. This acts very similar the `ExpediteHasManyPropertyController` version, except it is tuned for HasOne relationships.
