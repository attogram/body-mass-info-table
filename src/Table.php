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
            for (
                $mass = $this->config->startMass;
                $mass <= $this->config->endMass;
                $mass = $mass + $this->config->increment
            ) {
                $this->mass[] = $mass;
            }
        } else {
            for (
                $mass = $this->config->startMass;
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
                = number_format($this->human->getBodyFatPercentage(), 2);
            $this->info["$mass"]['leanMass']
                = number_format($this->human->getLeanBodyMass(), 2);
            $this->info["$mass"]['bmr']
                = number_format($this->human->getBMR(), 0, '', '');
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
     * @uses $this->info
     * @uses $this->config
     */
    public function include()
    {
        $table = '<table><tr><td colspan="14">' . $this->getTableTopic() . '</td></tr>' . $this->getTableHeader();

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
                . '<td class="righty">' . $info['mass'] . '</td>'
                . '<td class="righty">' . number_format(Conversion::kilogramsToPounds($mass), 2) . '</td>'
                . '<td class="righty">' . number_format(Conversion::kilogramsToStones($mass), 2) . '</td>'
                . '<td class="righty bold">' . $info['bmi'] . '</td>'
                . '<td class="righty">' . $info['bmiPrime'] . '</td>'
                . '<td class="righty">' . $info['bodyFat'] . '</td>'
                . '<td class="righty">' . $info['leanMass'] . '</td>'
                . '<td class="righty">' . $info['bmr'] . '</td>'
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
        $height = $this->human->getHeight()
            ? '<b>' . $this->human->getHeight() . ' meters</b>'
                . ' (' . number_format(Conversion::metersToInches($this->human->getHeight()), 2) . ' inches)'
                . ' (' . Conversion::metersToFeetAndInches($this->human->getHeight()) . ')'
            : $error;
        $age = $this->human->getAge()
            ? '<b>' . $this->human->getAge() . ' years</b>'
            : $error;
        $sex = ($this->human->getSex() == 'm' ? '<b>Male</b>' : '')
            . ($this->human->getSex() == 'f' ? '<b>Female</b>' : '')
            . (!in_array($this->human->getSex(), ['m', 'f']) ? $error : '');

        $bmiName = BodyMassIndex::getEquationName($this->config->equationBodyMassIndex);
        $bmiEquation =  BodyMassIndex::getEquationMetric($this->config->equationBodyMassIndex);

        $bfpName = BodyFatPercentage::getEquationName($this->config->equationBodyFatPercentage);
        $bfpEquation = BodyFatPercentage::getEquationMetric($this->config->equationBodyFatPercentage);

        $bmrName = BasalMetabolicRate::getEquationName($this->config->equationBasalMetabolicRate);
        $bmrEquation = BasalMetabolicRate::getEquationMetric($this->config->equationBasalMetabolicRate);

        return '<span class="bold">Body Mass Info Table</span>'
            . '<br />'
            . '<br />Height: ' . $height
            . '<br />Age:&nbsp;&nbsp;&nbsp; ' . $age
            . '<br />Sex:&nbsp;&nbsp;&nbsp; ' . $sex
            . '<br />'
            . '<small>'
            . '<br /><em>Equations used:</em>'
            . "<br />BMI - Body Mass Index:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  $bmiName: <small>$bmiEquation</small>"
            . "<br />BFP - Body Fat Percentage:&nbsp; $bfpName: <small>$bfpEquation</small>"
            . "<br />BMR - Basal Metabolic Rate: $bmrName: <small>$bmrEquation</small>"
            . '</small>'
            . '<br />'
            . '<br />';
    }

    /**
     * @return string
     */
    private function getTableHeader()
    {
        return '<tr>'
            . '<td>Description</td>'
            . '<td>Weight<br /><small>Kilograms</small></td>'
            . '<td>Weight<br /><small>Pounds</small></td>'
            . '<td>Weight<br /><small>Stones</small></td>'
            . '<td class="bold">BMI</td>'
            . '<td><small>BMI<br />Prime</small></td>'
            . '<td>Body<br />Fat<small> %</small></td>'
            . '<td>Lean<br />Mass</td>'
            . '<td>BMR</td>'
            . '<td>TDEE<br /><small>low</small></td>'
            . '<td>TDEE<br /><small>light</small></td>'
            . '<td>TDEE<br /><small>modrt</small></td>'
            . '<td>TDEE<br /><small>heavy</small></td>'
            . '<td>TDEE<br /><small>extrm</small></td>'
            . '</tr>';
    }
}
