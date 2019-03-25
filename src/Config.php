<?php
declare(strict_types = 1);

namespace Attogram\Body;

/**
 * Class Config
 * @package Attogram\Body
 */
class Config
{
    /** @var float */
    public $startMass = 100.0;
    /** @var float */
    public $endMass = 50.0;
    /** @var float */
    public $increment = 1.0;
    /** @var int */
    public $repeatHeader = 25;

    /** @var bool */
    public $showKilograms = true;
    /** @var bool */
    public $showPounds = true;
    /** @var bool */
    public $showStones = false;

    /** @var int*/
    public $equationBodyMassIndex = 1; // QUETELET_1832
    /** @var int*/
    public $equationBodyFatPercentage = 1; // JACKSON_2002
    /** @var int*/
    public $equationBasalMetabolicRate = 1; // KATCH_MCARDLE_2006
}
