# laragrad/pg-helper

This package provides a class `\Laragrad\Support\PgHelper` with functions for PostgreSQL array convertions.

## Installing

Run command in console

	composer require laragrad/pg-helper

## Functions

All functions are static.

### toPgArray()

Converts 1-dimension PHP-array to Pg-array string

Syntax:

`toPgArray(mixed $arr = null) : string`

Arguments:

* **$value** - Converted value. It is required and can by array, integer, string or null.

Returns a PostgreSQL array string.

### fromPgArray()

Converts PostgreSQL 1-dimension array string to PHP-array. 
Casts all array items into one of types 'string','int' or 'float' if it need.

Syntax:

`fromPgArray(string|null $value, string|null $castType = null) : array|null`

Arguments:

* **$value** - Converted value. It is required and must be one dimentional PostgreSQL array string or NULL.
* **$castType** - Array items cast type. Cast type value must be one of next strings: 'string', 'text', 'uuid', 'int', 'integer', 'float'.

Returns a PHP-array.

### isPgArray()

Find whether the variable is PostgreSQL string

Syntax:

`fromPgArray(mixed $value) : array`

Arguments:

* **$value** - Testing value

Returns TRUE if value is PostgreSQL one dimensional array string.
