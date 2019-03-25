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

    /**
     * @uses $this->config
     * @uses $this->data
     * @uses $this->human
     */
    public function include()
    {
        $this->data['height_meters'] = ($this->human->getHeightMeters() > 0)
            ? number_format($this->human->getHeightMeters(), 2)
            : '';
        $this->data['height_feet'] = ($this->human->getHeightFeet() > 0)
            ? $this->human->getHeightFeet()
            : '';
        $this->data['height_and_inches'] = ($this->human->getHeightAndInches() > 0)
            ? number_format($this->human->getHeightAndInches(), 1)
            : '';

        $this->data['age'] = ($this->human->getAge() > 0) ? $this->human->getAge() : '';

        $checked = ' checked="checked"';
        $this->data['checkM'] = $this->human->isMale() ? $checked : '';
        $this->data['checkF'] = $this->human->isFemale() ? $checked : '';

        $this->data['startMass'] = $this->config->startMass;
        $this->data['endMass'] = $this->config->endMass;
        $this->data['increment'] = $this->config->increment;
        $this->data['repeatHeader'] = $this->config->repeatHeader;

        $this->data['checkSK'] = $this->config->showKilograms ? $checked : '';
        $this->data['checkSP'] = $this->config->showPounds ? $checked : '';
        $this->data['checkSS'] = $this->config->showStones ? $checked : '';

        $this->includeTemplate('form');
    }

    /**
     * @param array $equations
     * @param string $config
     * @param string $bunchName
     * @return string
     */
    public function radioBunch(array $equations = [], string $config = '', string $bunchName = '')
    {
        $bunch = '';
        foreach ($equations as $equationId => $equationInfo) {
            $equationName = htmlspecialchars($equationInfo['name']);
            $equationMetric = htmlspecialchars($equationInfo['metric']);
            $equationMetricHtml = str_replace("\n", '<br />', $equationMetric);
            $equationMetricHtml = str_replace("\t", ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ', $equationMetricHtml);
            $equationCite = htmlspecialchars($equationInfo['cite']);
            $checked = '';
            if (property_exists($this->config, $config) && $equationId == $this->config->{$config}) {
                $checked = 'checked="checked" ';
            }
            $bunch .= ' &nbsp; '
                . '<span title="'
                . "$equationName\n--\n$bunchName = $equationMetric\n--\n$equationCite\n--"
                . '">'
                . '<input type="radio" id="' . $bunchName . '" name="' . $bunchName . '"'
                . ' title="" value="' . $equationId . '" ' . $checked . '/>'
                . " $equationName<br /> &nbsp;&nbsp;&nbsp;&nbsp; <small>$equationMetricHtml</small>"
                . '</span>'
                . '<br />';
        }

        return $bunch;
    }
}
