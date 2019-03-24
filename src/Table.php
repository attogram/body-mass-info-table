<?php
declare(strict_types = 1);

namespace Attogram\Body;

use Attogram\Body\Equation\BasalMetabolicRate;
use Attogram\Body\Equation\BodyFatPercentage;
use Attogram\Body\Equation\BodyMassIndex;

/**
 * Class Table
 * @package Attogram\Body
 */
class Table
{
    /** @var AverageHuman */
    private $human;

    /** @var Config */
    private $config;

    /** @var array */
    private $info = [];

    /** @var array */
    private $mass = [];

    /**
     * Table constructor.
     * @param AverageHuman $human
     * @param Config $config
     */
    public function __construct(AverageHuman $human, Config $config)
    {
        $this->human = $human;
        $this->config = $config;
        $this->setMass();
        $this->setInfo();
    }

    /**
     * @uses $this->mass
     * @uses $this->config
     */
    private function setMass()
    {
        $this->mass = [];
        if ($this->config->startMass < $this->config->endMass) {
            for ($mass = $this->config->startMass;
                 $mass <= $this->config->endMass;
                 $mass = $mass + $this->config->increment
            ) {
                $this->mass[] = $mass;
            }
        } else {
            for ($mass = $this->config->startMass;
                 $this->config->endMass <= $mass;
                 $mass = $mass - $this->config->increment
            ) {
                $this->mass[] = $mass;
            }
        }
    }

    /**
     * @uses $this->info
     * @uses $this->mass
     * @uses $this->human
     */
    private function setInfo()
    {
        $this->info = [];
        foreach ($this->mass as $mass) {
            $mass = (float) $mass;
            $this->human->setMass($mass);
            $this->info["$mass"]['mass'] = number_format($mass, 2);
            $this->info["$mass"]['bmi']
                = number_format(
                    $this->human->getBodyMassIndex($this->config->equationBodyMassIndex),
                    2
                );
            $this->info["$mass"]['bmiPrime']
                = number_format($this->human->getBodyMassIndexPrime(), 2);
            $this->info["$mass"]['bmiText']
                = Classification::getBmiClassText(
                    $this->human->getBodyMassIndex($this->config->equationBodyMassIndex)
                );
            $this->info["$mass"]['bmiColor']
                = Classification::getBmiClassColor(
                    $this->human->getBodyMassIndex($this->config->equationBodyMassIndex)
                );
            $this->info["$mass"]['bodyFat']
                = number_format($this->human->getBodyFatPercentage($this->config->equationBodyFatPercentage), 2);
            $this->info["$mass"]['leanMass']
                = number_format($this->human->getLeanBodyMass(), 2);
            $this->info["$mass"]['bmr']
                = number_format(
                    $this->human->getBasalMetabolicRate($this->config->equationBasalMetabolicRate),
                    0,
                    '',
                    ''
                );
            $this->info["$mass"]['tdeeSedentary']
                = number_format($this->human->getTDEE(PhysicalActivityLevel::SEDENTARY), 0, '', '');
            $this->info["$mass"]['tdeeLight']
                = number_format($this->human->getTDEE(PhysicalActivityLevel::LIGHT), 0, '', '');
            $this->info["$mass"]['tdeeModerate']
                = number_format($this->human->getTDEE(PhysicalActivityLevel::MODERATE), 0, '', '');
            $this->info["$mass"]['tdeeHeavy']
                = number_format($this->human->getTDEE(PhysicalActivityLevel::HEAVY), 0, '', '');
            $this->info["$mass"]['tdeeExtreme']
                = number_format($this->human->getTDEE(PhysicalActivityLevel::EXTREME), 0, '', '');

            if ($this->info["$mass"]['bmi'] == 0.00) {
                $this->info["$mass"]['bmi'] = '-';
            }
            if ($this->info["$mass"]['bmiPrime'] == 0.00) {
                $this->info["$mass"]['bmiPrime'] = '-';
            }
            if ($this->info["$mass"]['bodyFat'] == 0.00) {
                $this->info["$mass"]['bodyFat'] = '-';
            }
            if ($this->info["$mass"]['leanMass'] == 0.00) {
                $this->info["$mass"]['leanMass'] = '-';
            }
            if ($this->info["$mass"]['bmr'] == 0) {
                $this->info["$mass"]['bmr'] = '-';
            }
            if ($this->info["$mass"]['tdeeSedentary'] == 0) {
                $this->info["$mass"]['tdeeSedentary'] = '-';
            }
            if ($this->info["$mass"]['tdeeLight'] == 0) {
                $this->info["$mass"]['tdeeLight'] = '-';
            }
            if ($this->info["$mass"]['tdeeModerate'] == 0) {
                $this->info["$mass"]['tdeeModerate'] = '-';
            }
            if ($this->info["$mass"]['tdeeHeavy'] == 0) {
                $this->info["$mass"]['tdeeHeavy'] = '-';
            }
            if ($this->info["$mass"]['tdeeExtreme'] == 0) {
                $this->info["$mass"]['tdeeExtreme'] = '-';
            }
        }
    }

    /**
     * @uses $this->config
     * @uses $this->info
     */
    public function include()
    {
        $colspan = 14
            - ($this->config->showKilograms ? 0 : 1)
            - ($this->config->showPounds ? 0 : 1)
            - ($this->config->showStones ? 0 : 1);

        $table = '<table><tr><td colspan="' . $colspan . '">' . $this->getTableTopic()
            . '</td></tr>' . $this->getTableHeader();

        $count = 0;
        foreach ($this->info as $mass => $info) {
            $mass = (float) $mass;
            $count++;
            if ($count > $this->config->repeatHeader) {
                $count = 0;
                $table .= $this->getTableHeader();
            }
            $table .= '<tr style="background-color:' . Classification::getBmiClassColor($info['bmi']) . ';">'
                . '<td>' . Classification::getBmiClassText($info['bmi']) . '</td>'

                . (
                    $this->config->showKilograms
                        ? '<td class="righty bold">' . $info['mass'] . '</td>'
                        : ''
                )
                . (
                $this->config->showPounds
                    ? '<td class="righty">' . number_format(Conversion::kilogramsToPounds($mass), 2) . '</td>'
                    : ''
                )
                . (
                $this->config->showStones
                    ? '<td class="righty">' . Conversion::kilogramsToStonesAndPounds($mass) . '</td>'
                    : ''
                )
                . '<td class="righty bold">' . $info['bmi'] . '</td>'
                . '<td class="righty">' . $info['bmiPrime'] . '</td>'
                . '<td class="righty">' . $info['bodyFat'] . '</td>'
                . '<td class="righty">' . $info['leanMass'] . '</td>'
                . '<td class="righty bold">' . $info['bmr'] . '</td>'
                . '<td class="righty">' . $info['tdeeSedentary'] . '</td>'
                . '<td class="righty">' . $info['tdeeLight'] . '</td>'
                . '<td class="righty">' . $info['tdeeModerate'] . '</td>'
                . '<td class="righty">' . $info['tdeeHeavy'] . '</td>'
                . '<td class="righty">' . $info['tdeeExtreme'] . '</td>'
                . '</tr>';
        }
        $table .= $this->getTableHeader() . '</table>';

        print $table;
    }

    /**
     * @return string
     */
    private function getTableTopic()
    {
        $error = '<span class="error">Unknown</span>';
        $height = $this->human->getHeightMeters()
            ? '<b>' . $this->human->getHeightMeters() . ' meters</b>'
                . ' (' . number_format(Conversion::metersToInches($this->human->getHeightMeters()), 2) . ' inches)'
                . ' (' . Conversion::metersToFeetAndInches($this->human->getHeightMeters()) . ')'
            : $error;
        $age = $this->human->getAge()
            ? '<b>' . $this->human->getAge() . ' years</b>'
            : $error;
        $sex = ($this->human->getSex() == 'm' ? '<b>Male</b>' : '')
            . ($this->human->getSex() == 'f' ? '<b>Female</b>' : '')
            . (!in_array($this->human->getSex(), ['m', 'f']) ? $error : '');

        $bmiName = BodyMassIndex::getEquationName($this->config->equationBodyMassIndex);
        $bmiEquation = BodyMassIndex::getEquationMetric($this->config->equationBodyMassIndex);

        $bfpName = BodyFatPercentage::getEquationName($this->config->equationBodyFatPercentage);
        $bfpEquation = BodyFatPercentage::getEquationMetric($this->config->equationBodyFatPercentage);

        $bmrName = BasalMetabolicRate::getEquationName($this->config->equationBasalMetabolicRate);
        $bmrEquation = BasalMetabolicRate::getEquationMetric($this->config->equationBasalMetabolicRate);
        $bmrEquation =  str_replace("\n\t", '<br /> &nbsp;&nbsp;&nbsp; ', $bmrEquation);


        return '<span class="bold">Body Mass Info Table</span>'
            . '<br />'
            . '<br />Height: ' . $height
            . '<br />Age:&nbsp;&nbsp;&nbsp; ' . $age
            . '<br />Sex:&nbsp;&nbsp;&nbsp; ' . $sex
            . '<br />'
            . '<small>'
            . '<br /><em>Equations used:</em>'
            . "<br />BMI = <b>$bmiName</b>"
                . " =  <small>$bmiEquation</small>"
            . "<br />BFP = <b>$bfpName</b>  =  <small>$bfpEquation</small>"
            . "<br />BMR = <b>$bmrName</b>  = <small>$bmrEquation</small>"
            . '</small>'
            . '<br />'
            . '<br />';
    }

    /**
     * @return string
     */
    private function getTableHeader()
    {
        return '<tr class="tight">'
            . '<td>Classification</td>'
            . (
                $this->config->showKilograms
                    ? '<td>Weight<br /><small><br />Kilograms<br /><br /></small></td>'
                    : ''
            )
            . (
                $this->config->showPounds
                    ? '<td>Weight<br /><small><br />Pounds<br /><br /></small></td>'
                    : ''
            )
            . (
                $this->config->showStones
                    ? '<td>Weight<br /><small><br />Stones<br /><br /></small></td>'
                    : ''
            )
            . '<td >BMI<br /><small><br />Body Mass<br />Index</small></td>'
            . "<td><em>BMI<b>'</b><br /></em><small><br />BMI<br />Prime</small></td>"
            . '<td>BFP<br /><small><br />Body<br />Fat %</small></td>'
            . '<td>LBM<br /><small>Lean<br />Body<br />Mass</small></td>'
            . '<td>BMR<br /><small>Basal<br />Metabolic<br />Rate</small></td>'
            . '<td>TDEE<br /><small><br />Low<br />*' . PhysicalActivityLevel::SEDENTARY . '</small></td>'
            . '<td>TDEE<br /><small><br />Light<br />*' . PhysicalActivityLevel::LIGHT . '</small></td>'
            . '<td>TDEE<br /><small><br />Modrt<br />*' . PhysicalActivityLevel::MODERATE . '</small></td>'
            . '<td>TDEE<br /><small><br />Heavy<br />*' . PhysicalActivityLevel::HEAVY . '</small></td>'
            . '<td>TDEE<br /><small><br />Extrm<br />*' . PhysicalActivityLevel::EXTREME . '</small></td>'
            . '</tr>';
    }
}
