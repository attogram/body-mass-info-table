<?php
declare(strict_types = 1);

namespace Attogram\Body;

/**
 * Average Human
 */
class AverageHuman extends BasicHuman
{
    /** @var float $bmi - Body Mass Index */
    private $bmi = 0.0;

    /** @var float $bfp - Body Fat Percentage */
    private $bfp = 0.0;

    /** @var float $bmr - Basal Metabolic Rate */
    private $bmr = 0.0;

    /**
     * Get Body Mass Index (BMI)
     *      BMI = weight(kg) / height(m)^2
     *      BMI = 703 * weight(lb) / height(in)^2
     *
     * @return float
     */
    public function getBodyMassIndex()
    {
        if (!Util::isValidFloat($this->getHeight()) || !Util::isValidFloat($this->mass)) {
            return 0.0;
        }

        return $this->bmi = (float) $this->mass / ($this->getHeight() ** 2);
    }

    /**
     * @return float
     */
    public function getBodyMassIndexPrime()
    {
        if (!Util::isValidFloat($this->bmi)) {
            return 0.0;
        }

        return (float) ($this->bmi / 24.99) * 1;
    }

    /*

     */
    /**
     * Get Body Fat Percentage
     *
     *  Jackson formula: (1.39 x BMI) + (0.16 x age) - (10.34 x [m=1,f=0]) - 9
     *                 men: (1.39 x BMI) + (0.16 x age) - 19.34
     *               women: (1.39 x BMI) + (0.16 x age) - 9
     *
     * @see https://www.academia.edu/2711997/Measuring_obesity_results_are_poles_apart_obtained_by_BMI_and_bio-electrical_impedance_analysis
     *
     * @return float
     */
    public function getBodyFatPercentage()
    {
        if (!Util::isValidFloat($this->bmi)
            || !Util::isValidFloat($this->age)
            || !in_array($this->sex, ['m', 'f'])
        ) {
            return $this->bfp = 0.0;
        }

        $bodyFatSexFactor = 19.34; // male factor
        if ($this->isFemale()) {
            $bodyFatSexFactor = 9; // female factor
        }

        $bodyFat = (float) (1.39 * $this->bmi) + (0.16 * $this->age) - $bodyFatSexFactor;
        if ($bodyFat > 100 || $bodyFat < 0) {
            return $this->bfp = 0.0;
        }

        return $this->bfp = $bodyFat;
    }

    /**
     * Get Lean Body Mass
     *
     * @return float
     */
    public function getLeanBodyMass()
    {
        if (!Util::isValidFloat($this->bfp)) {
            return 0.0;
        }

        return (float) 100 - $this->bfp;
    }

    /**
     * Get Basal Metabolic Rate, based on mass and body fat percentage
     *
     *      Katch-McArdle Formula: BMR = 370 + (21.6 * (WeightInKilograms * (1 - BodyFatPercentage)))
     *
     * @return float
     */
    public function getBMR()
    {
        if (!Util::isValidFloat($this->bfp) || !Util::isValidFloat($this->mass)) {
            return $this->bmr = 0.0;
        }

        return $this->bmr = (float) 370 + (21.6 * ($this->mass * (1 - ($this->bfp / 100))));
    }

    /**
     * Get Total Daily Energy Expenditure
     *
     * @param float $physicalActivityLevel
     * @return float
     */
    public function getTDEE(float $physicalActivityLevel)
    {
        if (!Util::isValidFloat($this->bmr) || !Util::isValidFloat($physicalActivityLevel)) {
            return 0.0;
        }

        return (float) $this->bmr * $physicalActivityLevel;
    }
}
