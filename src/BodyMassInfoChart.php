<?php
declare(strict_types = 1);

namespace Attogram\Body;

use Attogram\Router\Router;

/**
 * Body Mass Info Chart
 */
class BodyMassInfoChart
{
    /** @var string Version*/
    const VERSION = '1.5.1';

    /** @var Router */
    private $router;

    /** @var string */
    private $templatesDirectory = '../templates/';

    /** @var AverageHuman */
    private $human;

    /** @var float */
    private $defaultAge = 0.0;

    /** @var float */
    private $defaultHeight = 0.0;

    /** @var float */
    private $startMass = 100.0;

    /** @var float */
    private $endMass = 50.0;

    /** @var float */
    private $increment = 1.0;

    /** @var array */
    private $massArray = [];

    /** @var array */
    private $infoArray = [];

    /**
     * Route Request
     */
    public function route()
    {
        $this->router = new Router();
        $this->router->allow('/', 'home');
        $this->router->allow('/about', 'about');
        $match = $this->router->match();

        if (!$match) {
            $this->pageNotFound();
            return;
        }

        $this->includeTemplate('header');
        switch ($match) {
            case 'home':
                $this->home();
                break;
            case 'about':
                $this->includeTemplate('about');
                break;
        }
        $this->includeTemplate('footer');
    }

    /**
     * 404 Page Not Found
     */
    private function pageNotFound()
    {
        header('HTTP/1.0 404 Not Found');
        $this->includeTemplate('header');
        print '<h1 style="padding:20px;">404 Page Not Found</h1>';
        $this->includeTemplate('footer');
    }

    /**
     * Home Page
     */
    private function home()
    {
        $this->human = new AverageHuman();
        $this->human->setAge(Utils::getFloatVarFromGet('a', $this->defaultAge));
        $this->human->setHeight(Utils::getFloatVarFromGet('h', $this->defaultHeight));
        $this->human->setSex(Utils::getEnumVarFromGet('x', ['m','f'], 'u'));

        $this->startMass = Utils::getFloatVarFromGet('s', $this->startMass);
        $this->endMass = Utils::getFloatVarFromGet('e', $this->endMass);
        $this->increment = Utils::getFloatVarFromGet('i', $this->increment);

        $this->includeTemplate('form');
        $this->chart();
    }

    /**
     * @uses $this->massArray
     */
    private function setMassArray()
    {
        $this->massArray = [];
        if ($this->startMass < $this->endMass) {
            for ($mass = $this->startMass; $mass <= $this->endMass; $mass = $mass + $this->increment) {
                $this->massArray[] = $mass;
            }
        } else {
            for ($mass = $this->startMass; $this->endMass <= $mass; $mass = $mass - $this->increment) {
                $this->massArray[] = $mass;
            }
        }
    }

    /**
     * @uses $this->infoArray
     */
    private function setInfoArray()
    {
        $infoArray = [];
        foreach ($this->massArray as $mass) {
            $mass = (float) $mass;
            $this->human->setMass($mass);
            $infoArray["$mass"]['mass'] = number_format($mass, 2);
            $infoArray["$mass"]['bmi'] = number_format($this->human->getBodyMassIndex(), 2);
            $infoArray["$mass"]['bmiPrime'] =  number_format($this->human->getBodyMassIndexPrime(), 2);
            $infoArray["$mass"]['bmiText'] = Utils::getBmiClassText($this->human->getBodyMassIndex());
            $infoArray["$mass"]['bmiColor'] = Utils::getBmiClassColor($this->human->getBodyMassIndex());
            $infoArray["$mass"]['bodyFat'] = number_format($this->human->getBodyFatPercentage(), 2);
            $infoArray["$mass"]['leanMass'] = number_format($this->human->getLeanBodyMass(), 2);
            $infoArray["$mass"]['bmr'] = number_format($this->human->getBasalMetablicRate(), 0, '', '');
            $infoArray["$mass"]['tdeeSedentary'] = number_format($this->human->getBasalMetablicRate() * 1.2, 0, '', '');
            $infoArray["$mass"]['tdeeLight'] = number_format($this->human->getBasalMetablicRate() * 1.375, 0, '', '');
            $infoArray["$mass"]['tdeeModerate'] = number_format($this->human->getBasalMetablicRate() * 1.55, 0, '', '');
            $infoArray["$mass"]['tdeeHeavy'] = number_format($this->human->getBasalMetablicRate() * 1.725, 0, '', '');
            $infoArray["$mass"]['tdeeExtreme'] = number_format($this->human->getBasalMetablicRate() * 1.9, 0, '', '');

            if ($infoArray["$mass"]['bmi'] == 0.00) {
                $infoArray["$mass"]['bmi'] = '-';
            }
            if ($infoArray["$mass"]['bmiPrime'] == 0.00) {
                $infoArray["$mass"]['bmiPrime'] = '-';
            }
            if ($infoArray["$mass"]['bodyFat'] == 0.00) {
                $infoArray["$mass"]['bodyFat'] = '-';
            }
            if ($infoArray["$mass"]['leanMass'] == 0.00) {
                $infoArray["$mass"]['leanMass'] = '-';
            }
            if ($infoArray["$mass"]['bmr'] == 0) {
                $infoArray["$mass"]['bmr'] = '-';
            }
            if ($infoArray["$mass"]['tdeeSedentary'] == 0) {
                $infoArray["$mass"]['tdeeSedentary'] = '-';
            }
            if ($infoArray["$mass"]['tdeeLight'] == 0) {
                $infoArray["$mass"]['tdeeLight'] = '-';
            }
            if ($infoArray["$mass"]['tdeeModerate'] == 0) {
                $infoArray["$mass"]['tdeeModerate'] = '-';
            }
            if ($infoArray["$mass"]['tdeeHeavy'] == 0) {
                $infoArray["$mass"]['tdeeHeavy'] = '-';
            }
            if ($infoArray["$mass"]['tdeeExtreme'] == 0) {
                $infoArray["$mass"]['tdeeExtreme'] = '-';
            }
        }
        $this->infoArray = $infoArray;
    }

    /**
     * @uses $this->infoArray
     */
    private function chart()
    {
        $this->setMassArray();
        $this->setInfoArray();

        print '<table>'
            . '<tr>'
            . '<td colspan="14">' . $this->getChartTopic() . '</td>'
            . '</tr>' . $this->getChartHeader();

        $count = 0;
        foreach ($this->infoArray as $mass => $info) {
            $mass = (float) $mass;
            $count++;
            if ($count > 30) {
                $count = 0;
                print $this->getChartHeader();
            }
            print '<tr style="background-color:' . Utils::getBmiClassColor($info['bmi']) . '">'
                . '<td>' . Utils::getBmiClassText($info['bmi']) . '</td>'
                . '<td align="right">' . $info['mass'] . '</td>'
                . '<td align="right">' . number_format(Conversions::kilogramsToPounds($mass), 2) . '</td>'
                . '<td align="right">' . number_format(Conversions::kilogramsToStones($mass), 2) . '</td>'
                . '<td align="right" class="bold">' . $info['bmi'] . '</td>'
                . '<td align="right">' . $info['bmiPrime'] . '</td>'
                . '<td align="right">' . $info['bodyFat'] . '</td>'
                . '<td align="right">' . $info['leanMass'] . '</td>'
                . '<td align="right">' . $info['bmr'] . '</td>'
                . '<td align="right">' . $info['tdeeSedentary'] . '</td>'
                . '<td align="right">' . $info['tdeeLight'] . '</td>'
                . '<td align="right">' . $info['tdeeModerate'] . '</td>'
                . '<td align="right">' . $info['tdeeHeavy'] . '</td>'
                . '<td align="right">' . $info['tdeeExtreme'] . '</td>'
                . '</tr>';
        }
        print $this->getChartHeader() . '</table>';
    }

    /**
     * @return string
     */
    private function getChartTopic()
    {
        $error = '<span class="error">Unknown</span>';
        return 'Body Mass Info Chart'
            . '<br /><br />Height: '
            . ($this->human->getHeight()
                ? $this->human->getHeight() . ' meters'
                    . ' (' . number_format(Conversions::metersToFeet($this->human->getHeight()), 2)
                    . ' feet)'
                    . ' (' . number_format(Conversions::metersToInches($this->human->getHeight()), 2)
                    . ' inches)'
                : $error
            )
            . '<br />Age&nbsp;&nbsp;&nbsp;: '
            . ($this->human->getAge() ? $this->human->getAge() . ' years' : $error)
            . '<br />Sex&nbsp;&nbsp;&nbsp;: '
            . ($this->human->getSex() == 'm' ? 'Male' : '')
            . ($this->human->getSex() == 'f' ? 'Female' : '')
            . (!in_array($this->human->getSex(), ['m', 'f']) ? '<span class="error">Unknown</span>' : '');
    }

    /**
     * @return string
     */
    private function getChartHeader()
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

    /**
     * @param string $templateName
     */
    private function includeTemplate(string $templateName)
    {
        /** @noinspection PhpIncludeInspection */
        include($this->templatesDirectory . $templateName . '.php');
    }
}
