<?php
declare(strict_types = 1);

namespace Attogram\Body;

/**
 * Class Conversion
 * @package Attogram\Body
 */
class Conversion
{
    /**
     * @param float $kilograms
     * @return float
     */
    public static function kilogramsToPounds(float $kilograms)
    {
        return (float) $kilograms * 2.2046226218;
    }

    /**
     * @param float $kilograms
     * @return float
     */
    public static function kilogramsToStones(float $kilograms)
    {
        return (float) $kilograms * 0.15747;
    }

    /**
     * @param float $kilograms
     * @return string
     */
    public static function kilogramsToStonesAndPounds(float $kilograms)
    {
        $pounds = static::kilogramsToPounds($kilograms);
        $stones = floor($pounds / 14);
        $remainingPounds = number_format($pounds - ($stones * 14), 1);

        return $stones
            . '<span style="font-size:xx-small;">st </span>'
            . '<span style="font-size:smaller;">' . $remainingPounds . '</span>'
            . '<span style="font-size:xx-small;">lbs</span></span>';
    }

    /**
     * @param float $inches
     * @return float
     */
    public static function inchesToMeters(float $inches)
    {
        return (float) $inches / 39.37;
    }
    /**
     * @param float $meters
     * @return float
     */
    public static function metersToInches(float $meters)
    {
        return (float) $meters * 39.37;
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
     * @param float $meters
     * @return string
     */
    public static function metersToFeetAndInches(float $meters)
    {
        $inches = static::metersToInches($meters);
        $feet = floor($inches / 12);
        $remainingInches = number_format($inches - ($feet * 12), 1);

        return $feet . "' " . $remainingInches . '"';
    }
}
