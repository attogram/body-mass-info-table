<?php
declare(strict_types = 1);

namespace Attogram\Body;

use Attogram\Router\Router;

/**
 * Web Control
 */
class Web
{
    /** @var Router Object*/
    private $router;

    /** @var string */
    private $templatesDirectory = '../templates/';

    /** @var AverageHuman Object */
    private $human;

    /** @var float */
    private $defaultAge = 0.0;

    /** @var float */
    private $defaultHeight = 0.0;

    /** @var string */
    private $defaultSex = 'm';

    /** @var float */
    private $startMass = 100.0;

    /** @var float */
    private $endMass = 50.0;

    /** @var float */
    private $increment = 1.0;

    /**
     * Route Request
     */
    public function route()
    {
        $this->router = new Router();
        $this->router->allow('/', 'home');
        $this->includeTemplate('header');
        switch ($this->router->match()) {
            case 'home':
                $this->pageHome();
                break;
            default: 
                $this->pageNotFound();
                break;
        }
        $this->includeTemplate('footer');
    }

    /**
     * Home Page
     */
    private function pageHome()
    {
        $height = Utils::getFloatVarFromGet('h', $this->defaultHeight);
        $age = Utils::getFloatVarFromGet('a', $this->defaultAge);
        $sex = Utils::getEnumVarFromGet('x', ['m','f','u'], $this->defaultSex);

        $this->startMass = Utils::getFloatVarFromGet('s', $this->startMass);
        $this->endMass = Utils::getFloatVarFromGet('e', $this->endMass);
        $this->increment = Utils::getFloatVarFromGet('i', $this->increment);

        $this->human = new AverageHuman($height, $age, $sex);

        $this->includeTemplate('form');

        if ($this->human->height) {
            $this->chart();
        }
    }

    /**
     * 404 Page Not Found
     */
    private function pageNotFound()
    {
        print '<h1>404 Page Not Found</h1>';
    }

    /**
     * Display Chart
     */
    private function chart()
    {
        $massArray = [];
        if ($this->startMass < $this->endMass) {
            for ($mass = $this->startMass; $mass <= $this->endMass; $mass = $mass + $this->increment) {
                $massArray[] = $mass;
            }
        } else {
            for ($mass = $this->startMass; $this->endMass <= $mass; $mass = $mass - $this->increment) {
                $massArray[] = $mass;
            }
        }

        $infoArray = [];
        foreach ($massArray as $mass) {
            $infoArray["$mass"]['mass'] = $mass;
            $infoArray["$mass"]['bmi'] = BodyCalculations::getBodyMassIndex(
                $mass,
                $this->human->height
            );
            $infoArray["$mass"]['bmiPrime'] = BodyCalculations::getBodyMassIndexPrime(
                $infoArray["$mass"]['bmi']
            );
            $infoArray["$mass"]['bmiText'] = BodyCalculations::getBmiClassText(
                $infoArray["$mass"]['bmi']
            );
            $infoArray["$mass"]['bmiColor'] = BodyCalculations::getBmiClassColor(
                $infoArray["$mass"]['bmi']
            );
            $infoArray["$mass"]['bodyFat'] = BodyCalculations::getEstimatedBodyFat(
                $infoArray["$mass"]['bmi'],
                $this->human->age,
                $this->human->sex
            );
            $infoArray["$mass"]['leanMass'] = BodyCalculations::getLeanMass(
                $infoArray["$mass"]['bodyFat']
            );
            $infoArray["$mass"]['bmr'] = BodyCalculations::getBmr(
                $mass,
                $infoArray["$mass"]['bodyFat']
            );
            $infoArray["$mass"]['tdeeSedentary'] = $infoArray["$mass"]['bmr'] * 1.2;
            $infoArray["$mass"]['tdeeLight'] = $infoArray["$mass"]['bmr'] * 1.375;
            $infoArray["$mass"]['tdeeModerate'] = $infoArray["$mass"]['bmr'] * 1.55;
            $infoArray["$mass"]['tdeeHeavy'] = $infoArray["$mass"]['bmr'] * 1.725;
            $infoArray["$mass"]['tdeeExtreme'] = $infoArray["$mass"]['bmr'] * 1.9;
        }

        print '
<div class="bw"> &nbsp; Height: ' . $this->human->height . ' meters</div>
<div class="bw"> &nbsp; Age&nbsp;&nbsp;&nbsp;: ' . $this->human->age . ' years</div>
<div class="bw"> &nbsp; Sex&nbsp;&nbsp;&nbsp;: ' . $this->human->sex . '</div>
<table>
<tr>
<td>Description</td>
<td>Weight</td>
<td>BMI</td>
<td>BMI<br />Prime</td>
<td>Body<br />Fat %</td>
<td>Lean<br />Mass %</td>
<td>BMR</td>
<td>TDEE<br />low</td>
<td>TDEE<br />lite</td>
<td>TDEE<br />modr</td>
<td>TDEE<br />hevy</td>
<td>TDEE<br />extr</td>
</tr>';

        foreach ($infoArray as $mass => $info) {
            $massDisplay = str_replace(
                'X',
                '&nbsp;',
                str_pad(
                    number_format((float) $mass, 2),
                    6,
                    'X',
                    STR_PAD_LEFT
                )
            );
            print '<tr style="background-color:' . BodyCalculations::getBmiClassColor($info['bmi']) . '">'
                . '<td>' . BodyCalculations::getBmiClassText($info['bmi']) . '</td>'
                . '<td>' . $massDisplay . ' kg</td>'
                . '<td>' . number_format($info['bmi'], 2) . '</td>'
                . '<td align="right">' . number_format($info['bmiPrime'], 2) . '</td>'
                . '<td align="right">' . number_format($info['bodyFat'], 2) . '%</td>'
                . '<td align="right">' . number_format($info['leanMass'], 2) . '%</td>'
                . '<td align="right">' . number_format($info['bmr'], 0, '', '') . '</td>'
                . '<td align="right">' . number_format($info['tdeeSedentary'], 0, '', '') . '</td>'
                . '<td align="right">' . number_format($info['tdeeLight'], 0, '', '') . '</td>'
                . '<td align="right">' . number_format($info['tdeeModerate'], 0, '', '') . '</td>'
                . '<td align="right">' . number_format($info['tdeeHeavy'], 0, '', '') . '</td>'
                . '<td align="right">' . number_format($info['tdeeExtreme'], 0, '', '') . '</td>'
                . '</tr>';
        }
        print '</table>';
    }

    /**
     * @param string $templateName
     */
    private function includeTemplate(string $templateName)
    {
        include($this->templatesDirectory . $templateName . '.php');
    }
}
