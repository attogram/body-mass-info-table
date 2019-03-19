<?php
declare(strict_types = 1);

namespace Attogram\Body;

/**
 * Class Classification
 * @package Attogram\Body
 */
class Classification
{
    const OBESE_CLASS_V         = 60.0;
    const OBESE_CLASS_IV        = 50.0;
    const OBESE_CLASS_III       = 40.0;
    const OBESE_CLASS_II_B      = 37.5;
    const OBESE_CLASS_II_A      = 35.0;
    const OBESE_CLASS_I_B       = 32.5;
    const OBESE_CLASS_I_A       = 30.0;
    const OVERWEIGHT_PRE_OBESE  = 27.5;
    const OVERWEIGHT            = 25.0;
    const NORMAL_WEIGHT_B       = 23.0;
    const NORMAL_WEIGHT_A       = 18.5;
    const UNDERWEIGHT_MILD      = 17.0;
    const UNDERWEIGHT_MODERATE  = 16.0;
    const UNDERWEIGHT_SEVERE    = 0.0;

    /**
     * @param mixed $bmi
     * @return string
     */
    public static function getBmiClassColor($bmi)
    {
        switch ($bmi) {
            case 0.0:
            default:
                return '#FFFFFF';
            case ($bmi >= self::OBESE_CLASS_V):
                return '#C71585';
            case ($bmi >= self::OBESE_CLASS_IV):
                return '#DD1589';
            case ($bmi >= self::OBESE_CLASS_III):
                return '#FF1493';
            case ($bmi >= self::OBESE_CLASS_II_B):
                return '#DC143C';
            case ($bmi >= self::OBESE_CLASS_II_A):
                return '#FF0000';
            case ($bmi >= self::OBESE_CLASS_I_B):
                return '#FF4500';
            case ($bmi >= self::OBESE_CLASS_I_A):
                return '#FF8C00';
            case ($bmi >= self::OVERWEIGHT_PRE_OBESE):
                return '#FFA800';
            case ($bmi >= self::OVERWEIGHT):
                return '#FFE730';
            case ($bmi >= self::NORMAL_WEIGHT_B):
                return '#EEFF88';
            case ($bmi >= self::NORMAL_WEIGHT_A):
                return '#DDFF88';
            case ($bmi >= self::UNDERWEIGHT_MILD):
                return '#FFD700';
            case ($bmi >= self::UNDERWEIGHT_MODERATE):
                return '#FFA500';
            case ($bmi < self::UNDERWEIGHT_MODERATE): // Underweight - Severe thinness
                return '#FF0000';
        }
    }

    /**
     * @param mixed $bmi
     * @return string
     */
    public static function getBmiClassText($bmi)
    {
        switch ($bmi) {
            case 0.0:
            default:
                return '-';
            case ($bmi >= self::OBESE_CLASS_V):
                return 'Obese <small>- Class V - Super-Super Obesity</small>';
            case ($bmi >= self::OBESE_CLASS_IV):
                return 'Obese <small>- Class IV - Super Obesity</small>';
            case ($bmi >= self::OBESE_CLASS_III):
                return 'Obese <small>- Class III - Morbid Obesity</small>';
            case ($bmi >= self::OBESE_CLASS_II_B):
                return 'Obese <small>- Class II - Severe Obesity +</small>';
            case ($bmi >= self::OBESE_CLASS_II_A):
                return 'Obese <small>- Class II - Severe Obesity</small>';
            case ($bmi >= self::OBESE_CLASS_I_B):
                return 'Obese <small>- Class I +</small>';
            case ($bmi >= self::OBESE_CLASS_I_A):
                return 'Obese <small>- Class I</small>';
            case ($bmi >= self::OVERWEIGHT_PRE_OBESE):
                return 'Overweight <small>- Pre-obese</small>';
            case ($bmi >= self::OVERWEIGHT):
                return 'Overweight';
            case ($bmi >= self::NORMAL_WEIGHT_B):
                return 'Normal weight <small>+</small>';
            case ($bmi >= self::NORMAL_WEIGHT_A):
                return 'Normal weight';
            case ($bmi >= self::UNDERWEIGHT_MILD):
                return 'Underweight <small>- Mild thinness</small>';
            case ($bmi >= self::UNDERWEIGHT_MODERATE):
                return 'Underweight <small>- Moderate thinness</small>';
            case ($bmi < self::UNDERWEIGHT_MODERATE): // Underweight - Severe thinness
                return 'Underweight <small>- Severe thinness</small>';
        }
    }
}
