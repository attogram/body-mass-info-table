<?php
declare(strict_types = 1);

namespace Attogram\Body;

use Attogram\Router\Router;

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
        header('HTTP/1.0 404 Not Found');
        $this->includeTemplate('header');
        print '<h1 class="alert alert-danger">404 Page Not Found</h1>';
        $this->includeTemplate('footer');
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

                $table = new Table($this->human, $this->config);
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
        $this->config = new Config();
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
}
