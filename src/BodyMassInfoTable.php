<?php
declare(strict_types = 1);

namespace Attogram\Body;

use Attogram\Router\Router;

/**
 * Body Mass Info Table
 */
class BodyMassInfoTable
{
    /** @var string Version*/
    const VERSION = '1.6.0';

    /** @var Router */
    private $router;

    /** @var string */
    private $templatesDirectory = '../templates/';

    /** @var AverageHuman */
    private $human;

    /** @var float */
    private $startMass = 100.0;

    /** @var float */
    private $endMass = 50.0;

    /** @var float */
    private $increment = 1.0;

    /** @var array */
    private $mass = [];

    /** @var array */
    private $info = [];

    /**
     * Route Request
     */
    public function route()
    {
        $this->router = new Router();
        $this->router->allow('/', 'home');
        $this->router->allow('/about', 'about');
        $match = $this->router->match();
        if ($match) {
            $this->routePage($match);
            return;
        }
        $this->pageNotFound();
    }

    /**
     * @param string $page
     */
    private function routePage(string $page)
    {
        $this->includeTemplate('header');
        switch ($page) {
            case 'home':
                $this->table();
                break;
            case 'about':
                $this->includeTemplate('about');
                break;
        }
        $this->includeTemplate('footer');
    }

    /**
     * Show The Table
     */
    private function table()
    {
        $this->human = new AverageHuman();
        $this->human->setAge(Utils::getFloatVarFromGet('a', 0.0));
        $this->human->setHeight(Utils::getFloatVarFromGet('h', 0.0));
        $this->human->setSex(Utils::getEnumVarFromGet('x', ['m','f'], 'u'));
        $this->startMass = Utils::getFloatVarFromGet('s', $this->startMass);
        $this->endMass = Utils::getFloatVarFromGet('e', $this->endMass);
        $this->increment = Utils::getFloatVarFromGet('i', $this->increment);
        $this->includeTemplate('form');
        $this->setMass();
        $this->setInfo();
        $table = new Table($this->info, $this->human);
        print $table->get();
    }

    /**
     * @uses $this->mass
     */
    private function setMass()
    {
        $this->mass = [];
        if ($this->startMass < $this->endMass) {
            for ($mass = $this->startMass; $mass <= $this->endMass; $mass = $mass + $this->increment) {
                $this->mass[] = $mass;
            }
        } else {
            for ($mass = $this->startMass; $this->endMass <= $mass; $mass = $mass - $this->increment) {
                $this->mass[] = $mass;
            }
        }
    }

    /**
     * @uses $this->info
     * @uses $this->mass
     */
    private function setInfo()
    {
        $this->info = [];
        foreach ($this->mass as $mass) {
            $mass = (float) $mass;
            $this->human->setMass($mass);
            $this->info["$mass"]['mass'] = number_format($mass, 2);
            $this->info["$mass"]['bmi'] = number_format($this->human->getBodyMassIndex(), 2);
            $this->info["$mass"]['bmiPrime'] =  number_format($this->human->getBodyMassIndexPrime(), 2);
            $this->info["$mass"]['bmiText'] = Utils::getBmiClassText($this->human->getBodyMassIndex());
            $this->info["$mass"]['bmiColor'] = Utils::getBmiClassColor($this->human->getBodyMassIndex());
            $this->info["$mass"]['bodyFat'] = number_format($this->human->getBodyFatPercentage(), 2);
            $this->info["$mass"]['leanMass'] = number_format($this->human->getLeanBodyMass(), 2);
            $this->info["$mass"]['bmr'] = number_format($this->human->getBasalMetablicRate(), 0, '', '');
            $this->info["$mass"]['tdeeSedentary'] = number_format($this->human->getBasalMetablicRate() *1.2, 0, '', '');
            $this->info["$mass"]['tdeeLight'] = number_format($this->human->getBasalMetablicRate() *1.375, 0, '', '');
            $this->info["$mass"]['tdeeModerate'] = number_format($this->human->getBasalMetablicRate() *1.55, 0, '', '');
            $this->info["$mass"]['tdeeHeavy'] = number_format($this->human->getBasalMetablicRate() *1.725, 0, '', '');
            $this->info["$mass"]['tdeeExtreme'] = number_format($this->human->getBasalMetablicRate() *1.9, 0, '', '');
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
     * @param string $templateName
     */
    private function includeTemplate(string $templateName)
    {
        /** @noinspection PhpIncludeInspection */
        include($this->templatesDirectory . $templateName . '.php');
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
}
