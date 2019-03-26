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
    const VERSION = '2.1.0';

    /** @var Router */
    private $router;

    /** @var AverageHuman */
    private $human;

    /** @var Config */
    private $config;

    /**
     * @uses $this->router
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
        $this->config->startMass = Util::getFloatVarFromGet('s', $this->config->startMass);
        $this->config->endMass = Util::getFloatVarFromGet('e', $this->config->endMass);
        $this->config->increment = Util::getFloatVarFromGet('i', $this->config->increment);
        $this->config->repeatHeader = Util::getIntVarFromGet('r', $this->config->repeatHeader);

        $this->config->showKilograms = Util::getBoolVarFromGetCheckbox('sk', $this->config->showKilograms);
        $this->config->showPounds = Util::getBoolVarFromGetCheckbox('sp', $this->config->showPounds);
        $this->config->showStones = Util::getBoolVarFromGetCheckbox('ss', $this->config->showStones);

        $this->config->equationBodyMassIndex
            = Util::getIntVarFromGet('bmi', $this->config->equationBodyMassIndex);
        $this->config->equationBodyFatPercentage
            = Util::getIntVarFromGet('bfp', $this->config->equationBodyFatPercentage);
        $this->config->equationBasalMetabolicRate
            = Util::getIntVarFromGet('bmr', $this->config->equationBasalMetabolicRate);
    }

    /**
     * @uses $this->human
     */
    private function setHuman()
    {
        $this->human = new AverageHuman();
        $this->human->setAge(Util::getFloatVarFromGet('a', 0));
        $this->human->setSex(Util::getEnumVarFromGet('x', ['m','f'], ''));
        $this->setHumanHeight();
    }

    /**
     * @uses $this->human
     */
    private function setHumanHeight()
    {
        $heightMeters = Util::getFloatVarFromGet('hm', 0);
        if (Util::isValidFloat($heightMeters)) {
            $this->human->setHeightMeters(Util::getFloatVarFromGet('hm', 0));

            return;
        }

        $heightFeet = Util::getFloatVarFromGet('hf', 0);
        $heightAndInches = Util::getFloatVarFromGet('hi', 0);
        $this->human->setHeightInches(($heightFeet * 12) + $heightAndInches);
    }
}
