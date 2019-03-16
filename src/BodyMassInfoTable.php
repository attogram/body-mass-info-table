<?php
declare(strict_types = 1);

namespace Attogram\Body;

use Attogram\Router\Router;
use stdClass;

/**
 * Body Mass Info Table
 */
class BodyMassInfoTable
{
    use TemplateTrait;

    /** @var string Version*/
    const VERSION = '1.9.0';

    const DEFAULT_AGE        = 0.0;
    const DEFAULT_HEIGHT     = 0.0;
    const DEFAULT_SEX        = '';
    const DEFAULT_START_MASS = 100.0;
    const DEFAULT_END_MASS   = 50.0;
    const DEFAULT_INCREMENT  = 1.0;

    /** @var Router */
    private $router;

    /** @var AverageHuman */
    private $human;

    /** @var stdClass */
    private $config;

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
                $this->setConfig();
                $this->setHuman();
                $form = new Form($this->human, $this->config);
                $form->includeForm();

                $this->setMass();
                $this->setInfo();
                $table = new Table($this->info, $this->human);
                print $table->get();
                break;
            case 'about':
                $this->includeTemplate('about');
                break;
        }
        $this->includeTemplate('footer');
    }

    /**
     * @uses $this->config
     */
    private function setConfig()
    {
        $this->config = new stdClass();
        $this->config->startMass = Util::getFloatVarFromGet('s', self::DEFAULT_START_MASS);
        $this->config->endMass = Util::getFloatVarFromGet('e', self::DEFAULT_END_MASS);
        $this->config->increment = Util::getFloatVarFromGet('i', self::DEFAULT_INCREMENT);
    }

    /**
     * @uses $this->human
     */
    private function setHuman()
    {
        $this->human = new AverageHuman();
        $this->human->setAge(Util::getFloatVarFromGet('a', self::DEFAULT_AGE));
        $this->human->setHeight(Util::getFloatVarFromGet('h', self::DEFAULT_HEIGHT));
        $this->human->setSex(Util::getEnumVarFromGet('x', ['m','f'], self::DEFAULT_SEX));
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
            $this->info["$mass"]['bmi'] = number_format($this->human->getBodyMassIndex(), 2);
            $this->info["$mass"]['bmiPrime'] =  number_format($this->human->getBodyMassIndexPrime(), 2);
            $this->info["$mass"]['bmiText'] = Classification::getBmiClassText($this->human->getBodyMassIndex());
            $this->info["$mass"]['bmiColor'] = Classification::getBmiClassColor($this->human->getBodyMassIndex());
            $this->info["$mass"]['bodyFat'] = number_format($this->human->getBodyFatPercentage(), 2);
            $this->info["$mass"]['leanMass'] = number_format($this->human->getLeanBodyMass(), 2);
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
