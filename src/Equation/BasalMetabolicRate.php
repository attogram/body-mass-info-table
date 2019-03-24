<?php
declare(strict_types = 1);

namespace Attogram\Body\Equation;

use Attogram\Body\Util;

/**
 * Class BasalMetabolicRate
 * @package Attogram\Body\Equation
 */
class BasalMetabolicRate extends Equation
{
    const KATCH_MCARDLE_2006 = 1;
    const KATCH_MCARDLE_HYBRID_20XX = 2;
    const HARRIS_BENEDICT_REVISED_1984 = 3;
    const MIFFLIN_ST_JEOR_1990 = 4;
    const CUNNINGHAM_1980 = 5;
    const HARRIS_BENEDICT_1919 = 6;

    protected static $equations = [
        self::KATCH_MCARDLE_2006 => [
            'name' => 'Katch-McArdle 2006',
            'metric' => '370 + (21.6 * (Weight_kilograms * (1 - BFP)))',
            'imperial' => '',
            'cite' => 'McArdle W (2006). Essentials of exercise physiology.'
                . ' Lippincott Williams &amp; Wilkins. p. 266. ISBN 9780495014836.',
        ],
        self::KATCH_MCARDLE_HYBRID_20XX => [
            'name' => 'Katch-McArdle-Hybrid 20XX',
            'metric' => '(370 * (1 - BFP)) + (21.6 * (Weight_kilograms * (1 - BFP)))'
                . ' + (6.17 * (Weight_kilograms * BFP))',
            'imperial' => '',
            'cite' => '<https://www.sailrabbit.com/bmr/>',
        ],
        self::HARRIS_BENEDICT_REVISED_1984 => [
            'name' => 'Harris-Benedict-Revised 1984',
            'metric' => 'Male: (13.397 * Weight_kilograms) + (4.799 * Height_cm) - (5.677 * Age) + 88.362'
                . "\n\t"
                . 'Female: (9.247 * Weight_kilograms) + (3.098 * Height_cm) - (4.330 * Age) + 447.593',
            'imperial' => '',
            'cite' => 'Roza AM, Shizgal HM (1984).'
                . ' "The Harris Benedict equation reevaluated: resting energy requirements and the body cell mass".'
                . ' The American Journal of Clinical Nutrition. 40 (1): 168–82. PMID 6741850.'
                . ' <https://www.ncbi.nlm.nih.gov/pubmed/6741850>',
        ],
        self::MIFFLIN_ST_JEOR_1990 => [
            'name' => 'Mifflin-St Jeor 1990',
            'metric' => 'Male: (10 * Weight_kilograms) + (6.25 * Height_cm) - (5 * Age) + 5'
                . "\n\t"
                . 'Female: (10 * Weight_kilograms) + (6.25 * Height_cm) - (5 * Age) - 161',
            'imperial' => '',
            'cite' => 'Mifflin MD, St Jeor ST, Hill LA, Scott BJ, Daugherty SA, Koh YO (1990).'
                . ' "A new predictive equation for resting energy expenditure in healthy individuals".'
                . ' The American Journal of Clinical Nutrition. 51 (2): 241–7. PMID 2305711.'
                . ' <https://www.ncbi.nlm.nih.gov/pubmed/2305711>',
        ],
        self::CUNNINGHAM_1980 => [
            'name' => 'Cunningham 1980',
            'metric' => '500 + (22 * (Weight_kilograms * (1 - BFP)))',
            'imperial' => '',
            'cite' => 'Cunningham JJ.'
                . ' A reanalysis of the factors influencing basal metabolic rate in normal adults.'
                . ' The American Journal of Clinical Nutrition 1980; 33: 2372-4.'
                . ' <https://www.ncbi.nlm.nih.gov/pubmed/7435418>',
        ],
        self::HARRIS_BENEDICT_1919 => [
            'name' => 'Harris-Benedict 1919',
            'metric' => 'Male: (13.7516 * Weight_kilograms) + (5.0033 * Height_cm) - (6.755 * Age) + 66.473'
                . "\n\t"
                . 'Female: (9.5634 * Weight_kilograms) + (1.8496 * Height_cm) - (4.6756 * Age) + 655.0955',
            'imperial' => '',
            'cite' => 'Harris JA, Benedict FG (1918). "A Biometric Study of Human Basal Metabolism".'
                . ' Proceedings of the National Academy of Sciences of the United States of America. 4 (12): 370–3.'
                . ' doi:10.1073/pnas.4.12.370. PMC 1091498. PMID 16576330.'
                . ' <https://www.ncbi.nlm.nih.gov/pmc/articles/PMC1091498/>'
                . "\n"
                . 'A Biometric Study of Basal Metabolism in Man.'
                . ' J. Arthur Harris and Francis G. Benedict. Washington, DC: Carnegie Institution, 1919.'
                . ' <https://archive.org/details/biometricstudyof00harruoft/page/98>',
        ],
    ];

    /**
     * Get Basal Metabolic Rate
     *
     * @param int $equationId
     * @param float $bodyFatPercentage
     * @return float
     */
    public function get(int $equationId = 0, float $bodyFatPercentage = 0.0)
    {
        if (!$this->isValidHumanMass()) {
            return 0.0;
        }

        if ($bodyFatPercentage > 0) {
            $bodyFatPercentage = (float) $bodyFatPercentage / 100;
        }

        switch ($equationId) {
            case self::KATCH_MCARDLE_2006:
                if (!Util::isValidFloat($bodyFatPercentage)) {
                    return  0.0;
                }
                // 370 + (21.6 * (Weight_kilograms * (1 - BFP)))
                $bmr = 370 + (21.6 * ($this->human->getMassKilograms() * (1 - $bodyFatPercentage)));
                break;

            case self::KATCH_MCARDLE_HYBRID_20XX:
                if (!Util::isValidFloat($bodyFatPercentage)) {
                    return  0.0;
                }
                // (370 * (1 - BFP)) + (21.6 * (Weight_kilograms * (1 - BFP))) + (6.17 * (Weight_kilograms * BFP))
                $bmr = (float) (
                          (370 * (1 - $bodyFatPercentage))
                        + (21.6 * ($this->human->getMassKilograms() * (1 - $bodyFatPercentage)))
                        + (6.17 * ($this->human->getMassKilograms() * $bodyFatPercentage))
                );
                break;

            case self::HARRIS_BENEDICT_REVISED_1984:
                if (!$this->isValidHumanHeight() || !$this->isValidHumanAge() || !$this->isValidHumanSex()) {
                    return  0.0;
                }
                switch ($this->human->getSex()) {
                    case 'm': // Male: (13.397 * Weight_kilograms) + (4.799 * Height_cm) - (5.677 * Age) + 88.362
                        $bmr = (float) (13.397 * $this->human->getMassKilograms())
                            + (4.799 * $this->human->getHeightCentimeters())
                            + (5.677 * $this->human->getAge())
                            + 88.362;
                        break;
                    case 'f': // Female: ( 9.247 * Weight_kilograms) + (3.098 * Height_cm) - (4.330 * Age) + 447.593
                        $bmr = (float) (9.247 * $this->human->getMassKilograms())
                            + (3.098 * $this->human->getHeightCentimeters())
                            + (4.330 * $this->human->getAge())
                            + 447.593;
                        break;
                    default:
                        return 0.0;
                }
                break;

            case self::MIFFLIN_ST_JEOR_1990:
                if (!$this->isValidHumanHeight() || !$this->isValidHumanAge() || !$this->isValidHumanSex()) {
                    return  0.0;
                }
                // Male: (10 * Weight_kilograms) + (6.25 * Height_cm) - (5 * Age) + 5
                // Female: (10 * Weight_kilograms) + (6.25 * Height_cm) - (5 * Age) - 161
                $bmr = (10 * $this->human->getMassKilograms())
                    + (6.25 * $this->human->getHeightCentimeters())
                    - (5 * $this->human->getAge());
                switch ($this->human->getSex()) {
                    case 'm':
                        $bmr += 5;
                        break;
                    case 'f':
                        $bmr -= 161;
                        break;
                    default:
                        return 0.0;
                }
                break;

            case self::CUNNINGHAM_1980:
                if (!Util::isValidFloat($bodyFatPercentage)) {
                    return  0.0;
                }
                // 500 + (22 * (Weight_kilograms * (1 - BFP)))
                $bmr = (float) 500 + (22 * ($this->human->getMassKilograms() * (1 - $bodyFatPercentage)));
                break;

            case self::HARRIS_BENEDICT_1919:
                if (!$this->isValidHumanHeight() || !$this->isValidHumanAge() || !$this->isValidHumanSex()) {
                    return  0.0;
                }
                switch ($this->human->getSex()) {
                    case 'm': // Male: (13.7516 * Weight_kilograms) + (5.0033 * Height_cm) - (6.755  * Age) + 66.473
                        $bmr = (13.7516 * $this->human->getMassKilograms())
                            + (5.0033 * $this->human->getHeightCentimeters())
                            - (6.755 * $this->human->getAge())
                            + 66.473;
                        break;
                    case 'f': // Female: (9.5634 * Weight_kilograms) + (1.8496 * Height_cm) - (4.6756 * Age) + 655.0955
                        // BMR = 655.1 + ( 9.563 × weight in kg ) + ( 1.850 × height in cm ) – ( 4.676 × age in years )
                        $bmr = (9.5634 * $this->human->getMassKilograms())
                            + (1.8496 * $this->human->getHeightCentimeters())
                            - (4.6756 * $this->human->getAge())
                            + 655.0955;
                        break;
                    default:
                        return 0.0;
                }
                break;

            default:
                return 0.0;
        }

        if ($bmr < 0) {
            return 0.0;
        }

        return $bmr;
    }
}
