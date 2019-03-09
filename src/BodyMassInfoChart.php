<?php
declare(strict_types = 1);

namespace Attogram\Body;

use Attogram\Router\Router;

/**
 * Web Control
 */
class BodyMassInfoChart
{
    /** @var string Version*/
    const VERSION = '1.3.0';

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

    /** @var string */
    private $defaultSex = 'm';

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
        $this->human->height = (float) Utils::getFloatVarFromGet('h', $this->defaultHeight);
        $this->human->age = (float) Utils::getFloatVarFromGet('a', $this->defaultAge);
        $this->human->sex = (string) Utils::getEnumVarFromGet('x', ['m','f','u'], $this->defaultSex);

        $this->startMass = Utils::getFloatVarFromGet('s', $this->startMass);
        $this->endMass = Utils::getFloatVarFromGet('e', $this->endMass);
        $this->increment = Utils::getFloatVarFromGet('i', $this->increment);

        $this->includeTemplate('form');

        if ($this->human->height) {
            $this->chart();
        }
    }

    /**
     * @return void
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
     * @return void
     */
    private function setInfoArray()
    {
        $infoArray = [];
        foreach ($this->massArray as $mass) {
            $mass = (float) $mass;
            $this->human->mass = $mass;
            $infoArray["$mass"]['mass'] = $mass;
            $infoArray["$mass"]['bmi'] = $this->human->getBodyMassIndex();
            $infoArray["$mass"]['bmiPrime'] = $this->human->getBodyMassIndexPrime();
            $infoArray["$mass"]['bmiText'] = Utils::getBmiClassText($infoArray["$mass"]['bmi']);
            $infoArray["$mass"]['bmiColor'] = Utils::getBmiClassColor($infoArray["$mass"]['bmi']);
            $infoArray["$mass"]['bodyFat'] = $this->human->getBodyFatPercentage();
            $infoArray["$mass"]['leanMass'] =  $this->human->getLeanBodyMass();
            $infoArray["$mass"]['bmr'] = $this->human->getBasalMetablicRate();
            $infoArray["$mass"]['tdeeSedentary'] = $infoArray["$mass"]['bmr'] * 1.2;
            $infoArray["$mass"]['tdeeLight'] = $infoArray["$mass"]['bmr'] * 1.375;
            $infoArray["$mass"]['tdeeModerate'] = $infoArray["$mass"]['bmr'] * 1.55;
            $infoArray["$mass"]['tdeeHeavy'] = $infoArray["$mass"]['bmr'] * 1.725;
            $infoArray["$mass"]['tdeeExtreme'] = $infoArray["$mass"]['bmr'] * 1.9;
        }
        $this->infoArray = $infoArray;
    }

    /**
     * Print Chart
     */
    private function chart()
    {
        $this->setMassArray();
        $this->setInfoArray();

        print '<table>'
            . '<tr>'
            . '<td colspan="13">' . $this->getChartTopic() . '</td>'
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
                . '<td align="right">' . number_format($this->human->mass, 2) . '<small> kg</small></td>'
                . '<td align="right">' . number_format(Utils::kilogramsToPounds($mass), 2) . '<small> lb</small></td>'
                . '<td align="right">' . number_format($info['bmi'], 2) . '</td>'
                . '<td align="right">' . number_format($info['bmiPrime'], 2) . '</td>'
                . '<td align="right">' . number_format($info['bodyFat'], 2) . '<small>%</small></td>'
                . '<td align="right">' . number_format($info['leanMass'], 2) . '<small>%</small></td>'
                . '<td align="right">' . number_format($info['bmr'], 0, '', '') . '</td>'
                . '<td align="right">' . number_format($info['tdeeSedentary'], 0, '', '') . '</td>'
                . '<td align="right">' . number_format($info['tdeeLight'], 0, '', '') . '</td>'
                . '<td align="right">' . number_format($info['tdeeModerate'], 0, '', '') . '</td>'
                . '<td align="right">' . number_format($info['tdeeHeavy'], 0, '', '') . '</td>'
                . '<td align="right">' . number_format($info['tdeeExtreme'], 0, '', '') . '</td>'
                . '</tr>';
        }
        print $this->getChartHeader() . '</table>';
    }

    /**
     * @return string
     */
    private function getChartTopic()
    {
        return 'Body Mass Info Chart'
            . '<br /><br />Height: ' . $this->human->height . ' meters'
            . ' (' . number_format(Utils::metersToFeet($this->human->height), 2) . ' feet)'
            . ' (' . number_format(Utils::metersToInches($this->human->height), 2) . ' inches)'
            . '<br />Age: ' . $this->human->age . ' years'
            . '<br />Sex: ' . strtoupper($this->human->sex);
    }

    /**
     * @return string
     */
    private function getChartHeader()
    {
        return '<tr>'
            . '<td>Description</td>'
            . '<td>Weight<br /><small>kilograms</small></td>'
            . '<td>Weight<br /><small>pounds</small></td>'
            . '<td>BMI</td>'
            . '<td><small>BMI<br />Prime</small></td>'
            . '<td>Body<br />Fat %</td>'
            . '<td>Lean<br />Mass %</td>'
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
