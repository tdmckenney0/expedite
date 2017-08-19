# Helpers

## PermissionsHelper

The `PermissionsHelper` was built to provide similar capabilities of the `PermissionsComponent` to the `View` class.

### has($controller = null, $action = null, $ability = null)

`$ability` is no longer used, it is retained for backwards compatibility purposes. This method checks to see if a user can access a specific `/$controller/$action` and can be used to limit objects displayed in the `View`. 

### can($controller = null, $action = null, $ability = null)

Essentially the same method as `has()`, however no error checking or assumption is done. 

### in($group = null)

Checks to see if the current user belongs to `$group`. 

## ExpediteFormHelper

`ExpediteFormHelper` is the absolute base for all views to render properly. Expedite has a built-in widget kit based on _jQueryUI_ and _BlueprintCSS_. This class extends CakePHP's built-in `FormHelper` and is configured to replaced it in `AppController`. This Class is well documented within the comments, so please refer to there. 



