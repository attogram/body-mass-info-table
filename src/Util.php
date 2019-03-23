<?php
declare(strict_types = 1);

namespace Attogram\Body;

/**
 * Class Util
 * @package Attogram\Body
 */
class Util
{
    /**
     * @param mixed $var
     * @param float $default
     * @return float
     */
    public static function getFloatVar($var, float $default = 0.0)
    {
        return ($var && is_numeric($var) && $var > 0)
            ? (float) $var
            : $default;
    }

    /**
     * @param string $name
     * @param float  $default
     * @return float
     */
    public static function getFloatVarFromGet(string $name, float $default = 0.0)
    {
        if (!isset($_GET[$name])) {
            return $default;
        }

        return static::getFloatVar($_GET[$name], $default);
    }

    /**
     * @param mixed $var
     * @param int $default
     * @return float
     */
    public static function getIntVar($var, int $default = 0)
    {
        return ($var && preg_match('/^[0-9]*$/', $var) && $var > 0)
            ? (int) $var
            : $default;
    }

    /**
     * @param string $name
     * @param int  $default
     * @return float
     */
    public static function getIntVarFromGet(string $name, int $default = 0)
    {
        if (!isset($_GET[$name])) {
            return $default;
        }

        return static::getIntVar($_GET[$name], $default);
    }

    /**
     * @param mixed  $var
     * @param array  $enumArray
     * @param string $default
     * @return string
     */
    public static function getEnumVar($var, array $enumArray, string $default = '')
    {
        return ($var && in_array($var, $enumArray))
            ? (string) $var
            : $default;
    }

    /**
     * @param string $name
     * @param array $enumArray
     * @param string $default
     * @return string
     */
    public static function getEnumVarFromGet(string $name, array $enumArray, string $default = '')
    {
        if (!isset($_GET[$name])) {
            return $default;
        }

        return static::getEnumVar($_GET[$name], $enumArray, $default);
    }

    /**
     * @param mixed $var
     * @return bool
     */
    public static function isValidFloat($var = null)
    {
        if ($var && $var > 0.0 && is_float($var)) {
            return true;
        }

        return false;
    }
}
