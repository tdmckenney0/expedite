# Behaviors

## EnumerationBehavior

This behavior lays the ground work for `Enumerated` Types. These are fields that have a limited number of values, but do not merit a database table and join. 

### beforeSave(Model $model)

Detects the conditions associated with `Enumerated` types. It checks if it is not a file upload and that it's key is numeric. Then it `implodes` the `Array` result for storage in a `Varchar`. 

## NullBehavior

The `NullBehavior` is simple: Any field that can be made null, takes empty strings and makes them an actual `null` data type. This is all automatic. 

### getFilePath(Model $Model)

Returns the current Model's file path. 

### beforeDelete(Model $Model, $cascade = true)

If the physical file exists, delete it before deleting from Database. 

### afterFind(Model $Model, $results, $primary = false)

Resolve the location of the file, and update the field with the full path before passing to caller. 