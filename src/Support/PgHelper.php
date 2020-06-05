<?php

namespace Laragrad\Support;

class PgHelper
{

    /**
     * Converts 1-dimension PHP-array to Pg-array string
     *
     * @param array $value
     * @return string
     */
    public static function toPgArray(array $arr)
    {
        foreach ($arr as &$value) {

            if (is_array($value)) {
                throw new \Exception('toPgArray(): 1st argument must by a one dimensional array');
            } elseif (is_null($value)) {
                $value = 'NULL';
                continue;
            } elseif (is_bool($value)) {
                $value = $value ? 'true' : 'false';
            }

            if (!is_string($value)) {
                $value = (string) $value;
            }

            $toWrap = (strpbrk($value, ',{}"\\') !== false);

            if (strpos($value, '\\') !== false) {
                $value = str_replace('\\', '\\\\', $value);
            }
            if (strpos($value, '"') !== false) {
                $value = str_replace('"', '\"', $value);
            }

            if ($toWrap) {
                $value = '"' . $value . '"';
            }
        }

        return '{' . implode(',', $arr) . '}';
    }

    /**
     * Converts PostgreSQL 1-dimension array string to PHP-array
     *
     * Use $castType to cast all items into 'string', 'int' or 'float'
     *
     * @param string $pgArray
     * @param string $castType
     * @return array
     */
    public static function fromPgArray(string $pgArray, string $castType = null)
    {
        if (!self::isPgArray($pgArray)) {
            throw new \Exception('fromPgArray(): 1st argument must be a valide PostgreSQL one dimensional array string');
        }

        if ($pgArray == '{}') {
            return [];
        }

        $result = str_getcsv(substr($pgArray, 1, -1));

        foreach ($result as &$value) {
            if ($value == 'NULL') {
                $value = null;
            }
            if ($castType) {
                switch ($castType) {
                    case 'int':
                        $value = (int) $value;
                        break;
                    case 'float':
                        $value = (float) $value;
                        break;
                    case 'string':
                        $value = (string) $value;
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
     * @param mixed $pgArray
     * @return boolean
     */
    public static function isPgArray($pgArray)
    {
        if (is_string($pgArray)) {
            if (strpos($pgArray, '{') === 0 || strlen($pgArray) == (strrpos($pgArray, '}') + 1)) {
                return true;
            }
        }

        return false;
    }
}