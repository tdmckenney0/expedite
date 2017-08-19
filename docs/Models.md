# Models

## AppModel

This is CakePHP's default model in which all other models inherit. The model layer of Expedite is not altered much from CakePHP's stock setup.

### App::uses('Set', 'Utility') & App::uses('Hash', 'Utility')

CakePHP provides the `Set` and `Hash` libraries for better array management (which is key in PHP). `Set` was depreciated by CakePHP during development of Expedite, so a few classes still use this library. It is **not** recommended to use `Set`. `Hash` is set's replacement, and while it does much of the same thing, it's more consistent and faster. 

### $actsAs = array('Containable', 'Enumeration')

Imports the `EnumerationBehavior` and `ContainableBehavior`.

### public $enumerations = array();

Initializes the `$enumerations` property so that it can be checked on every model, even those without enumerations.

###  __construct($id = false, $table = null, $ds = null)

This is technically an undocumented override. It allows automatically switching to a developer database when Debug is turned on. Currently disabled. 