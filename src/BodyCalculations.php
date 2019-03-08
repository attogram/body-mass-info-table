<?php
declare(strict_types = 1);

namespace Attogram\Body;

/**
 * Body Calculaions for the Average Human
 */
class BodyCalculations
{
    /**
     * Standard Body Mass Index (BMI) formula:
     *      BMI = weight(kg) / height(m)^2
     *      BMI = 703 * weight(lb) / height(in)^2
     *
     * @param float $mass - in Kilograms
     * @param float $height - in Meters
     * @return float
     */
    public static function getBodyMassIndex(float $mass, float $height)
    {
        if (!$height || $height <= 0) {
            return 0.0;
        }
        return $mass / ($height ** 2);
    }

    // New Oxford BMI formula:
    //  BMI = 1.3 * weight(kg) / height(m)^2.5
    //  BMI = 5734 * weight(lb) / height(in)^2.5

    /**
     * @param float $bmi
     * @return float
     */
    public static function getBodyMassIndexPrime(float $bmi)
    {
        return (float) ($bmi / 24.99) * 1;
    }

    /**
     * Get Estimated Body Fat, based on BMI
     *      formula: (1.39 x BMI) + (0.16 x age) - (10.34 x [m=1,f=0]) - 9
     *          men: (1.39 x BMI) + (0.16 x age) - 19.34
     *        women: (1.39 x BMI) + (0.16 x age) - 9
     *
     * @param float  $bmi - Body Mass Index
     * @param float  $age - Age, in years
     * @param string $sex - Sex - m, f
     * @return float
     */
    public static function getEstimatedBodyFat(float $bmi, float $age, string $sex)
    {
        $bodyFatSexFactor = 19.34; // male factor
        if ($sex == 'f') {
            $bodyFatSexFactor = 9; // female factor
        }
        $bodyFat = (float) (1.39 * $bmi) + (0.16 * $age) - $bodyFatSexFactor;
        if ($bodyFat > 100 || $bodyFat < 0) {
            return 0.0;
        }

        return $bodyFat;
    }

    /**
     * @param float $bodyFat
     * @return float
     */
    public static function getLeanMass(float $bodyFat)
    {
        if ($bodyFat <= 0) {
            return 0.0;
        }

        return (float) 100 - $bodyFat;
    }

    /**
     * Get Estimated Base Metabolic Rate, based on mass and body fat percentage
     *      Katch-McArdle BMR = 370 + ( 21.6 * ( WeightInKilograms * ( 1 - BodyFatPercentage ) ) )
     *
     * @param float $mass - body mass in kilograms
     * @param float $bodyFat
     * @return float
     */
    public static function getBmr(float $mass, float $bodyFat) {
        if ($bodyFat <= 0.0) {
            return 0.0;
        }

        return (float) 370 + (21.6 * ($mass * (1 - ($bodyFat / 100))));
    }
    // Katch-McArdle Hybrid BMR
    //  (370 * ( 1 - P )) + (21.6 * (W * (1 - P))) + (6.17 * (W * P))
    //  Variables: W=weight in kilograms, P=body fat percentage

    // Cunningham BMR
    //  500 + ( 22 * ( W * ( 1 - P ) ) )
    //  Variables: W=weight in kilograms, P=body fat percentage

    // ??
    // BMR = (height in centimetres x 6.25) + (weight in kilograms x 9.99) – (age x 4.92) – 161.

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
                return 'Obese - Class V - Super-Super Obesity';
            case ($bmi >= 50.0):
                return 'Obese - Class IV - Super Obesity';
            case ($bmi >= 40.0):
                return 'Obese - Class III - Morbid Obesity';
            case ($bmi >= 37.5):
                return 'Obese - Class II - Very Severe Obesity';
            case ($bmi >= 35.0):
                return 'Obese - Class II - Severe Obesity';
            case ($bmi >= 32.5):
                return 'Obese - Class I - Very Obese';
            case ($bmi >= 30.0):
                return 'Obese - Class I - Obese';
            case ($bmi >= 27.5):
                return 'Overweight - Pre-obese';
            case ($bmi >= 25.0):
                return 'Overweight';
            case ($bmi >= 23.0):
                return 'Normal weight +';
            case ($bmi >= 18.5):
                return 'Normal weight';
            case ($bmi >= 17.0):
                return 'Underweight - Mild thinness';
            case ($bmi >= 16.0):
                return 'Underweight - Moderate thinness';
            case ($bmi < 16.0):
                return 'Underweight - Severe thinness';
            default:
                return '?';
        }
    }
}
