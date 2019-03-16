<?php
declare(strict_types = 1);

namespace Attogram\Body;

/**
 * Class Form
 * @package Attogram\Body
 */
class Form
{
    use TemplateTrait;

    /** @var AverageHuman */
    private $human;

    /** @var Config */
    private $config;

    /**
     * Form constructor.
     * @param AverageHuman $human
     * @param Config $config
     */
    public function __construct(AverageHuman $human, Config $config)
    {
        $this->human = $human;
        $this->config = $config;
    }

    public function includeForm()
    {
        $this->data['height'] = ($this->human->getHeight() > 0) ? $this->human->getHeight() : '';
        $this->data['age'] = ($this->human->getAge() > 0) ? $this->human->getAge() : '';

        $checked = ' checked="checked"';
        $this->data['checkM'] = $this->human->isMale() ? $checked : '';
        $this->data['checkF'] = $this->human->isFemale() ? $checked : '';

        $this->data['startMass'] = $this->config->startMass;
        $this->data['endMass'] = $this->config->endMass;
        $this->data['increment'] = $this->config->increment;

        $this->includeTemplate('form');
    }
}
