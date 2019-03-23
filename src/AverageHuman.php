<?php
declare(strict_types = 1);

namespace Attogram\Body;

use Attogram\Body\Equation\BasalMetabolicRate;
use Attogram\Body\Equation\BodyFatPercentage;
use Attogram\Body\Equation\BodyMassIndex;

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
     * @param int $equation
     * @return float
     */
    public function getBodyMassIndex(int $equation)
    {
        return $this->bmi = (new BodyMassIndex($this))->get($equation);
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

    /**
     * @param int $equation
     * @return float
     */
    public function getBodyFatPercentage(int $equation)
    {
        return $this->bfp = (new BodyFatPercentage($this))->get($equation, $this->bmi);
    }

    /**
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
     * @param int $equation
     * @return float
     */
    public function getBasalMetabolicRate(int $equation)
    {
        return $this->bmr = (new BasalMetabolicRate($this))->get($equation, $this->bfp);
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
