<?php
declare(strict_types = 1);

namespace Attogram\Body;

/**
 * Table
 */
class Table
{
    /** @var AverageHuman */
    private $human;

    /** @var array */
    private $info = [];

    /**
     * @param array $info
     * @param AverageHuman $human
     */
    public function __construct(array $info, AverageHuman $human)
    {
        $this->human = $human;
        $this->info = $info;
    }

    /**
     * @uses $this->info
     * @return string
     */
    public function get()
    {
        $table = '<table><tr><td colspan="14">' . $this->getTableTopic() . '</td></tr>' . $this->getTableHeader();

        $count = 0;
        foreach ($this->info as $mass => $info) {
            $mass = (float) $mass;
            $count++;
            if ($count > 30) {
                $count = 0;
                $table .= $this->getTableHeader();
            }
            $table .= '<tr style="background-color:' . Classification::getBmiClassColor($info['bmi']) . '">'
                . '<td>' . Classification::getBmiClassText($info['bmi']) . '</td>'
                . '<td class="righty">' . $info['mass'] . '</td>'
                . '<td class="righty">' . number_format(Conversions::kilogramsToPounds($mass), 2) . '</td>'
                . '<td class="righty">' . number_format(Conversions::kilogramsToStones($mass), 2) . '</td>'
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

        return $table;
    }

    /**
     * @return string
     */
    private function getTableTopic()
    {
        $error = '<span class="error">Unknown</span>';
        $height = $this->human->getHeight()
            ? '<b>' . $this->human->getHeight() . ' meters</b>'
                . ' (' . number_format(Conversions::metersToInches($this->human->getHeight()), 2) . ' inches)'
                . ' (' . number_format(Conversions::metersToFeet($this->human->getHeight()), 2) . ' feet)'
            : $error;
        $age = $this->human->getAge()
            ? '<b>' . $this->human->getAge() . ' years</b>'
            : $error;
        $sex = ($this->human->getSex() == 'm' ? '<b>Male</b>' : '')
            . ($this->human->getSex() == 'f' ? '<b>Female</b>' : '')
            . (!in_array($this->human->getSex(), ['m', 'f']) ? $error : '');

        return '<span class="bold">Body Mass Info Table</span>'
            . '<br />Height: ' . $height
            . '<br />Age&nbsp;&nbsp;&nbsp;: ' . $age
            . '<br />Sex&nbsp;&nbsp;&nbsp;: ' . $sex;
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
