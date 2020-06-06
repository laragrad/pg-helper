<?php

namespace Laragrad\Support;

class PgHelper
{

    /**
     * Converts 1-dimension PHP-array to Pg-array string
     *
     * @param mixed $item
     * @throws \Exception
     * @return string|null
     */
    public static function toPgArray($value)
    {
        if (is_null($value)) {
            return $value;
        } elseif (is_scalar($value)) {
            if (is_string($value) || is_integer($value)) {
                $value = [$value];
            } else {
                throw new \Exception('toPgArray(): 1st argument must by a one dimensional array or string or integer or NULL');
            }
        }

        foreach ($value as &$item) {

            if (is_array($item)) {
                throw new \Exception('toPgArray(): 1st argument must by a one dimensional array');
            } elseif (is_null($item)) {
                $item = 'NULL';
                continue;
            } elseif (is_bool($item)) {
                $item = $item ? 'true' : 'false';
            }

            if (!is_string($item)) {
                $item = (string) $item;
            }

            $toWrap = (strpbrk($item, ',{}"\\') !== false);

            if (strpos($item, '\\') !== false) {
                $item = str_replace('\\', '\\\\', $item);
            }
            if (strpos($item, '"') !== false) {
                $item = str_replace('"', '\"', $item);
            }

            if ($toWrap) {
                $item = '"' . $item . '"';
            }
        }

        return '{' . implode(',', $value) . '}';
    }

    /**
     * Converts PostgreSQL 1-dimension array string to PHP-array
     *
     * Use $castType to cast all items into 'string', 'int' or 'float'
     *
     * @param string|null $pgArray
     * @param string|null $castType
     * @throws \Exception
     * @return array|null
     */
    public static function fromPgArray($value, string $castType = null)
    {
        if (is_null($value)) {
            return null;
        }

        if (!self::isPgArray($value)) {
            throw new \Exception('fromPgArray(): 1st argument must be a valide PostgreSQL one dimensional array string');
        }

        // Check for empty Pg-array
        if ($value == '{}') {
            return [];
        }

        $result = str_getcsv(substr($value, 1, -1));

        foreach ($result as &$item) {
            if ($item == 'NULL') {
                $item = null;
            }
            if ($castType) {
                switch ($castType) {
                    case 'int':
                    case 'integer':
                        $item = (int) $item;
                        break;
                    case 'float':
                        $item = (float) $item;
                        break;
                    case 'string':
                    case 'text':
                    case 'uuid':
                        $item = (string) $item;
                        break;
                    default:
                        break;
                }
            }
        }

        return $result;
    }

    /**
     * Find whether the variable is PostgreSQL string
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isPgArray($value)
    {
        if (is_string($value)) {
            if (strpos($value, '{') === 0 || strlen($value) == (strrpos($value, '}') + 1)) {
                return true;
            }
        }

        return false;
    }
}