<?php
declare(strict_types = 1);

namespace Attogram\Body;

/**
 * Utility functions
 */
class Utils
{
    /**
     * @param mixed $var
     * @param float $default
     * @return float
     */
    public static function getFloatVar($var, float $default = 0.0)
    {
        return ($var && is_numeric($var) && $var > 0)
            ? (float)$var
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

    public static function getEnumVarFromGet(string $name, array $enumArray, string $default = '')
    {
        if (!isset($_GET[$name])) {
            return $default;
        }

        return static::getEnumVar($_GET[$name],$enumArray, $default);
    }

    /**
     * @param float $kilograms
     * @return float
     */
    public static function kilogramsToPounds(float $kilograms)
    {
        return (float) $kilograms * 2.2046226218;
    }

    /**
     * @param float $meters
     * @return float
     */
    public static function metersToInches(float $meters)
    {
        return (float) $meters * 39.370;
    }

    /**
     * @param float $meters
     * @return float
     */
    public static function metersToFeet(float $meters)
    {
        return (float) $meters * 3.2808;
    }
}
