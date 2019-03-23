<?php
declare(strict_types = 1);

namespace Attogram\Body;

use Attogram\Router\Router;

/**
 * Class BodyMassInfoTable
 * @package Attogram\Body
 */
class BodyMassInfoTable
{
    use TemplateTrait;

    /** @var string Version*/
    const VERSION = '1.10.1';

    /** @var Router */
    private $router;

    /** @var AverageHuman */
    private $human;

    /** @var Config */
    private $config;

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
        $this->includeTemplate('404');
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
                (new Form($this->human, $this->config))->include();
                (new Table($this->human, $this->config))->include();
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
        $this->config = new Config();
        $this->config->startMass = Util::getFloatVarFromGet('s', Config::DEFAULT_START_MASS);
        $this->config->endMass = Util::getFloatVarFromGet('e', Config::DEFAULT_END_MASS);
        $this->config->increment = Util::getFloatVarFromGet('i', Config::DEFAULT_INCREMENT);
        $this->config->repeatHeader = Util::getFloatVarFromGet('r', Config::DEFAULT_REPEAT_HEADER);
        $this->config->equationBodyMassIndex = Util::getIntVarFromGet('bmi', Config::DEFAULT_EQUATION_BMI);
        $this->config->equationBodyFatPercentage = Util::getIntVarFromGet('bfp', Config::DEFAULT_EQUATION_BFP);
        $this->config->equationBasalMetabolicRate = Util::getIntVarFromGet('bmr', Config::DEFAULT_EQUATION_BMR);
    }

    /**
     * @uses $this->human
     */
    private function setHuman()
    {
        $this->human = new AverageHuman();
        $this->human->setAge(Util::getFloatVarFromGet('a', Config::DEFAULT_AGE));
        $this->human->setHeight(Util::getFloatVarFromGet('h', Config::DEFAULT_HEIGHT));
        $this->human->setSex(Util::getEnumVarFromGet('x', ['m','f'], Config::DEFAULT_SEX));
    }
}
