<?php
declare(strict_types = 1);

namespace Attogram\Body\Equation;

use Attogram\Body\AverageHuman;
use Attogram\Body\Util;

/**
 * Class Equation
 * @package Attogram\Body\Equation
 */
class Equation
{
    /** @var array */
    protected static $equations = [];

    /** @var AverageHuman */
    protected $human;

    /**
     * Equation constructor.
     * @param AverageHuman|null $human
     */
    public function __construct(AverageHuman $human = null)
    {
        $this->human = $human;
    }

    /**
     * @return array
     */
    public static function getEquations()
    {
        return static::$equations;
    }

    /**
     * @param int $equationId
     * @return string
     */
    public static function getEquationName(int $equationId)
    {
        return static::getEquationValue($equationId, 'name');
    }

    /**
     * @param int $equationId
     * @return string
     */
    public static function getEquationMetric(int $equationId)
    {
        return static::getEquationValue($equationId, 'metric');
    }

    /**
     * @param int $equationId
     * @param string $name
     * @return string
     */
    private static function getEquationValue(int $equationId, string $name)
    {
        if (isset(static::$equations[$equationId][$name])) {
            return static::$equations[$equationId][$name];
        }
        return '?';
    }

    /**
     * @param AverageHuman $human
     */
    public function setHuman(AverageHuman $human)
    {
        $this->human = $human;
    }

    /**
     * @return bool
     */
    protected function isValidHuman()
    {
        if ($this->human instanceof AverageHuman) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    protected function isValidHumanHeight()
    {
        if ($this->isValidHuman() && Util::isValidFloat($this->human->getHeight())) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    protected function isValidHumanMass()
    {
        if ($this->isValidHuman() && Util::isValidFloat($this->human->getMass())) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    protected function isValidHumanAge()
    {
        if ($this->isValidHuman() && Util::isValidFloat($this->human->getAge())) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    protected function isValidHumanSex()
    {
        if ($this->isValidHuman() && in_array($this->human->getSex(), ['m','f'])) {
            return true;
        }
        return false;
    }
}
