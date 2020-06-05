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

`toPgArray(array $arr) : string`

Arguments:

* $arr - One dimentional PHP-array

Returns a PostgreSQL array string.

### fromPgArray()

Converts PostgreSQL 1-dimension array string to PHP-array. 
Casts all array items into one of types 'string','int' or 'float' if it need.

Syntax:

`fromPgArray(string $pgArray, string $castType = null) : array`

Arguments:

* $pgArray - One dimentional PostgreSQL array string
* $castType - Array items cast type. Enabled values are 'string','int' or 'float'.

Returns a PHP-array.

### isPgArray()

Find whether the variable is PostgreSQL string

Syntax:

`fromPgArray(mixed $value) : array`

Arguments:

* $value - Testing value

Returns TRUE if value is PostgreSQL one dimensional array string.
