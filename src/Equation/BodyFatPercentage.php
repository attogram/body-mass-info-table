<?php
declare(strict_types = 1);

namespace Attogram\Body\Equation;

use Attogram\Body\Util;

/**
 * Class BodyFatPercentage
 * @package Attogram\Body\Equation
 */
class BodyFatPercentage extends Equation
{
    const JACKSON_2002         = 1;
    const DEURENBERG_1998      = 2;
    const GALLAGHER_1996       = 3;
    const DEURENBERG_1991      = 4;
    const JACKSON_POLLOCK_1984 = 5;

    protected static $equations = [
        self::JACKSON_2002 => [
            'name'     => 'Jackson 2002',
            'metric'   => '(1.39 * BMI) + (0.16 * Age) - (10.34 * [M=1,F=0]) - 9.0',
            'imperial' => '',
            'cite'     => 'Jackson, A.S., Stanforth, P.R. and Gagnon, J. (2002)'
                        . ' The effect of sex, age and race on estimating percentage body fat from body mass index:'
                        . ' The heritage family study.'
                        . ' International Journal of Obesity and Related Metabolic Disorders, 26, 789-96.'
                        . ' <https://www.ncbi.nlm.nih.gov/pubmed/12037649>',
        ],
        self::DEURENBERG_1998 => [
            'name'     => 'Deurenberg 1998',
            'metric'   => '(1.29 * BMI) + (0.20 * Age) - (11.40 * [M=1,F=0]) - 8.03',
            'imperial' => '',
            'cite'     => 'Deurenberg, P., Yap, M. and van Staveren, W.A. (1998)'
                        . ' Body mass index and percent body fat. A meta analysis among different ethnic groups.'
                        . ' International Journal of Obesity, 22, 1164-1171.doi:10.1038/sj.ijo.0800741'
                        . ' <https://www.nature.com/articles/0800741>',
        ],
        self::GALLAGHER_1996 => [
            'name'     => 'Gallagher 1996',
            'metric'   => '(1.46 * BMI) + (0.14 * Age) - (11.6 * [M=1,F=0]) – 10',
            'imperial' => '',
            'cite'     => 'Gallagher, D., Visser, M., Sepulveda, D., et al. (1996)'
                        . ' How useful is body mass index for comparison of body fatness'
                        . ' across age, sex and ethnic groups. American Journal of Epidemiology, 143, 228-239.'
                        . ' <https://academic.oup.com/aje/article/143/3/228/77940>',
        ],
        self::DEURENBERG_1991 => [
            'name'     => 'Deurenberg 1991',
            'metric'   => '(1.20 * BMI) + (0.23 * Age) - (10.80 * [M=1,F=0]) - 5.42',
            'imperial' => '',
            'cite'     => 'Deurenberg, P., Westrate, J.A. and Seidell, J.C. (1991)'
                . ' Body mass index as a measure of body fatness: Age- and sex-specific prediction formulas.'
                . ' British Journal of Nutrition, 65, 105-114.doi:10.1079/BJN19910073'
                . ' <https://www.cambridge.org/core/journals/british-journal-of-nutrition/article/body-mass-index-as-a-measure-of-body-fatness-age-and-sexspecific-prediction-formulas/9C03B18E1A0E4CDB0441644EE64D9AA2>',
        ],
        self::JACKSON_POLLOCK_1984 => [
            'name'     => 'Jackson-Pollock 1984',
            'metric'   => '(1.61 * BMI) + (0.13 * Age) - (12.10 * [M=1,F=0]) - 13.95',
            'imperial' => '',
            'cite'     => 'Jackson, A.S., Pollock, M.L. and Ward, A. (1980)'
                . ' Generalized equations for predicting body density of women.'
                . ' Medicine &amp; Science in Sports &amp; Exercise, 12, 175-182.doi:10.1249/00005768-198023000-00009'
                . ' <https://insights.ovid.com/crossref?an=00005768-198023000-00009>'
                . "\n"
                . 'Jackson, A.S. (1984) Research design and analysis of data procedures for predicting body density.'
                . ' Medicine &amp; Science in Sports &amp; Exercise, 16, 616-620.doi:10.1249/00005768-198412000-00018'
                . ' <https://insights.ovid.com/crossref?an=00005768-198412000-00018>',
        ],
    ];

    /**
     * @param int $equationId
     * @param float $bmi
     * @return float
     */
    public function get(int $equationId = 0, float $bmi = 0)
    {
        if (!Util::isValidFloat($bmi) || !$this->isValidHumanAge() || !$this->isValidHumanSex()) {
            return 0.0;
        }
        switch ($equationId) {
            case self::JACKSON_2002: // (1.39 x BMI) + (0.16 x age) - (10.34 x [m=1,f=0]) - 9
                $bodyFat = $this->bodyFatFromBmi($bmi, 1.39, 0.16, 10.34, 9);
                break;
            case self::DEURENBERG_1998: // (1.29 * BMI) + (0.20 * Age) - (11.40 * [M=1,F=0]) - 8.03
                $bodyFat = $this->bodyFatFromBmi($bmi, 1.29, 0.2, 11.4, 8.03);
                break;
            case self::GALLAGHER_1996: // (1.46 * BMI) + (0.14 * Age) - (11.6 * [M=1,F=0]) – 10
                $bodyFat = $this->bodyFatFromBmi($bmi, 1.46, 0.14, 11.6, 10);
                break;
            case self::DEURENBERG_1991: // (1.20 * BMI) + (0.23 * Age) - (10.80 * [M=1,F=0]) - 5.42
                $bodyFat = $this->bodyFatFromBmi($bmi, 1.20, 0.23, 10.8, 5.42);
                break;
            case self::JACKSON_POLLOCK_1984: // (1.61 * BMI) + (0.13 * Age) - (12.10 * [M=1,F=0]) - 13.95
                $bodyFat = $this->bodyFatFromBmi($bmi, 1.61, 0.13, 12.10, 13.95);
                break;
            default:
                return 0.0;
        }
        if ($bodyFat > 100 || $bodyFat < 0) {
            return 0.0;
        }

        return $bodyFat;
    }

    /**
     * @param float $bmi
     * @param float $bmiFactor
     * @param float $ageFactor
     * @param float $maleFactor
     * @param float $endFactor
     * @return float
     */
    private function bodyFatFromBmi(float $bmi, float $bmiFactor, float $ageFactor, float $maleFactor, float $endFactor)
    {
        return (float) ($bmiFactor * $bmi)
            + ($ageFactor * $this->human->getAge())
            - ($this->human->isMale() ? $maleFactor : 0)
            - $endFactor;
    }
}
