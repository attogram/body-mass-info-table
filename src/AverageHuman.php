<?php
declare(strict_types = 1);

namespace Attogram\Body;

/**
 * The Average Human
 */
class AverageHuman
{
    /** @var float $height - length, in meters */
    public $height = 0.0;

    /** @var float $age - age, in years */
    public $age = 0.0;

    /** @var string $age - sex, m=male f=female, u=unknown*/
    public $sex = 'u';

    /** @var float $mass - weight, in kilograms */
    public $mass = 0.0;

    /** @var float $bmi - Body Mass Index */
    private $bmi = 0.0;

    /** @var float $bfp - Body Fat Percentage */
    private $bfp = 0.0;

    /** @var float $lbm - Lean Body Mass */
    private $lbm = 0.0;

    /**
     * Standard Body Mass Index (BMI)
     *      BMI = weight(kg) / height(m)^2
     *      BMI = 703 * weight(lb) / height(in)^2
     *
     * @return float
     */
    public function getBodyMassIndex()
    {
        if (!$this->isValidFloat($this->height) || !$this->isValidFloat($this->mass)) {
            return 0.0;
        }

        return $this->bmi = (float) $this->mass / ($this->height ** 2);
    }

    /**
     * @return float
     */
    public function getBodyMassIndexPrime()
    {
        if (!$this->isValidFloat($this->bmi)) {
            return 0.0;
        }

        return (float) ($this->bmi / 24.99) * 1;
    }

    /**
     * Get Estimated Body Fat, based on BMI
     *      formula: (1.39 x BMI) + (0.16 x age) - (10.34 x [m=1,f=0]) - 9
     *          men: (1.39 x BMI) + (0.16 x age) - 19.34
     *        women: (1.39 x BMI) + (0.16 x age) - 9
     *
     * @return float
     */
    public function getBodyFatPercentage()
    {
        if (!$this->isValidFloat($this->bmi) || !$this->isValidFloat($this->age)) {
            return $this->bfp = 0.0;
        }

        $bodyFatSexFactor = 19.34; // male factor
        if ($this->sex == 'f') {
            $bodyFatSexFactor = 9; // female factor
        }
        $bodyFat = (float) (1.39 * $this->bmi) + (0.16 * $this->age) - $bodyFatSexFactor;
        if ($bodyFat > 100 || $bodyFat < 0) {
            return $this->bfp = 0.0;
        }

        return $this->bfp = $bodyFat;
    }

    /**
     * @return float
     */
    public function getLeanBodyMass()
    {
        if (!$this->isValidFloat($this->bfp)) {
            return $this->lbm = 0.0;
        }

        return $this->lbm = (float) 100 - $this->bfp;
    }

    /**
     * Get Estimated Basal Metabolic Rate, based on mass and body fat percentage
     *      Katch-McArdle BMR = 370 + ( 21.6 * ( WeightInKilograms * ( 1 - BodyFatPercentage ) ) )
     *
     * @return float
     */
    public function getBasalMetablicRate() {
        if (!$this->isValidFloat($this->bfp) || !$this->isValidFloat($this->mass)) {
            return 0.0;
        }

        return (float) 370 + (21.6 * ($this->mass * (1 - ($this->bfp / 100))));
    }

    /**
     * @param mixed $var
     * @return bool
     */
    private function isValidFloat($var = null)
    {
        if ($var && $var > 0.0 && is_float($var)) {
            return true;
        }

        return false;
    }
}
