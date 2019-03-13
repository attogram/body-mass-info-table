<?php
declare(strict_types = 1);

namespace Attogram\Body;

/**
 * Class Conversions
 * @package Attogram\Body
 */
class Conversions
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
