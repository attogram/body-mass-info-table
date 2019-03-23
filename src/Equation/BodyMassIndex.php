<?php
declare(strict_types = 1);

namespace Attogram\Body\Equation;

/**
 * Class BodyMassIndex
 * @package Attogram\Body\Equation
 */
class BodyMassIndex extends Equation
{
    const QUETELET_1832  = 1;
    const TREFETHEN_2013 = 2;

    protected static $equations = [
        self::QUETELET_1832 => [
            'name'     => 'Quetelet 1832',
            'metric'   => 'Weight_kilograms / (Height_meters ^2)',
            'imperial' => '(703 * Weight_pounds) / (Height_inches ^2)',
            'cite'     => 'Quetelet, Ad.. "Recherches sur le penchant au crime aux différens âges.." '
                . "Nouveaux mémoires de l'Académie Royale des Sciences et Belles-Lettres de Bruxelles 7 (1832): "
                . '1. <http://eudml.org/doc/180535>.',
        ],
        self::TREFETHEN_2013 => [
            'name'     => 'Trefethen 2013',
            'metric'   => '(1.3 * Weight_kilograms) / (Height_meters ^2.5)',
            'imperial' => '(5734 * Weight_pounds) / (Height_inches ^2.5)',
            'cite'     => '<https://people.maths.ox.ac.uk/trefethen/bmi.html>',
        ],
    ];

    /**
     * @param int $equationId
     * @return float
     */
    public function get(int $equationId = 0)
    {
        if (!$this->isValidHumanHeight() || !$this->isValidHumanMass()) {
            return 0.0;
        }

        switch ($equationId) {
            case self::QUETELET_1832:
                return (float) $this->human->getMass() / ($this->human->getHeight() ** 2);
            case self::TREFETHEN_2013:
                return (float) (1.3 * $this->human->getMass()) / ($this->human->getHeight() ** 2.5);
            default:
                return 0.0;
        }
    }
}
