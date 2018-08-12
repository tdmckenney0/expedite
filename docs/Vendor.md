# Vendors

Vendor is the folder where external libraries (Non-CakePHP) are stored for use within the application. Expedite has a few.

## DocxWriter.php

The `DocxWriter` class uses Cake's built in `File`, `Folder`, and `Xml` classes to breakdown, modify, and reassemble Microsoft Word DOCX documents.

### extractAll(File $file = null)

This method takes a `File` object, and extracts it's contents to `app/tmp`. Use caution, this method does not check if the file object is a valid DOCX file.

### create(array $filenames = array(), $template = null)

Takes a list of file paths, `$filenames`, to XML files or XML strings as well as a filepath to a `$template`. The method will then build the DOCX file anmd return a `File` object to the result. It can then be moved or copied wherever. This has a varied success rate which is why it was replaced with `PHPDocx`. But it is great for quick-and-dirty modifications.

### extract(File $file = null)

This method takes a `File` that points to a DOCX document. It then will extract the primary document `document.xml` from it and return an `XML` object.

## OdtWriter.php

This class and `DocxWriter` should have extended a base class or one extends the other. It is identical in every way with a few exceptions:

 - Operates on OpenDocument ODT files.
 - `__extractODT()` is identical to `extractAll()`
