# Models

## AppModel

This is CakePHP's default model in which all other models inherit. The model layer of Expedite is not altered much from CakePHP's stock setup.

### App::uses('Hash', 'Utility')

CakePHP provides the `Hash` library for better array management (which is key in PHP).

### $actsAs = array('Containable', 'Enumeration')

Imports the `EnumerationBehavior` and `ContainableBehavior`.

### public $enumerations = array();

Initializes the `$enumerations` property so that it can be checked on every model, even those without enumerations.
