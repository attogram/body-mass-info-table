<?php
declare(strict_types = 1);

namespace Attogram\Body\Equation;

use Attogram\Body\AverageHuman;
use Attogram\Body\HumanTrait;

/**
 * Class Equation
 * @package Attogram\Body\Equation
 */
class Equation
{
    use HumanTrait;

    /** @var array */
    protected static $equations = [];

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
}
