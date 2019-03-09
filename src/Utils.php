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

    /**
     * @param float $bmi
     * @return string
     */
    public static function getBmiClassColor(float $bmi) {
        switch($bmi) {
            case ($bmi >= 60.0): // Obese - Class V - Super-Super Obesity
                return '#C71585';
            case ($bmi >= 50.0): // Obese - Class IV - Super Obesity
                return '#DD1589';
            case ($bmi >= 40.0): // Obese - Class III - Morbid Obesity
                return '#FF1493';
            case ($bmi >= 37.5): // Obese - Class II - Very Severe Obesity
                return '#DC143C';
            case ($bmi >= 35.0): // Obese - Class II - Severe Obesity
                return '#FF0000';
            case ($bmi >= 32.5): // Obese - Class I +
                return '#FF4500';
            case ($bmi >= 30.0): // Obese - Class I
                return '#FF8C00';
            case ($bmi >= 27.5): // Overweight - Pre-obese
                return '#FFA800';
            case ($bmi >= 25.0): // Overweight
                return '#FFD700';
            case ($bmi >= 23.0): // Normal weight +
                return '#BBFF33';
            case ($bmi >= 18.5): // Normal weight
                return '#AAFF33';
            case ($bmi >= 17.0): // Underweight - Mild thinness
                return '#FFD700';
            case ($bmi >= 16.0): // Underweight - Moderate thinness
                return '#FFA500';
            case ($bmi < 16.0):  // Underweight - Severe thinness
                return '#FF0000';
            default:
                return '#808080';
        }
    }

    /**
     * @param float $bmi
     * @return string
     */
    public static function getBmiClassText(float $bmi) {
        switch($bmi) {
            case ($bmi >= 60.0):
                return 'Obese - Class V <small>- Super-Super Obesity</small>';
            case ($bmi >= 50.0):
                return 'Obese - Class IV <small>- Super Obesity</small>';
            case ($bmi >= 40.0):
                return 'Obese - Class III <small>- Morbid Obesity</small>';
            case ($bmi >= 37.5):
                return 'Obese - Class II <small>- Very Severe Obesity</small>';
            case ($bmi >= 35.0):
                return 'Obese - Class II <small>- Severe Obesity</small>';
            case ($bmi >= 32.5):
                return 'Obese - Class I <small>- Very Obese</small>';
            case ($bmi >= 30.0):
                return 'Obese - Class I <small>- Obese</small>';
            case ($bmi >= 27.5):
                return 'Overweight <small>- Pre-obese</small>';
            case ($bmi >= 25.0):
                return 'Overweight';
            case ($bmi >= 23.0):
                return 'Normal weight <small>+</small>';
            case ($bmi >= 18.5):
                return 'Normal weight';
            case ($bmi >= 17.0):
                return 'Underweight <small>- Mild thinness</small>';
            case ($bmi >= 16.0):
                return 'Underweight <small>- Moderate thinness</small>';
            case ($bmi < 16.0):
                return 'Underweight <small>- Severe thinness</small>';
            default:
                return '?';
        }
    }
}
