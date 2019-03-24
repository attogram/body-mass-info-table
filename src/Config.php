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
    const DEFAULT_AGE = 0.0;
    /** @var float */
    const DEFAULT_HEIGHT = 0.0;
    /** @var string */
    const DEFAULT_SEX = '';
    /** @var float */
    const DEFAULT_START_MASS = 100.0;
    /** @var float */
    const DEFAULT_END_MASS = 50.0;
    /** @var float */
    const DEFAULT_INCREMENT = 1.0;
    /** @var int */
    const DEFAULT_REPEAT_HEADER = 25;
    /** @var int */
    const DEFAULT_EQUATION_BMI = 1;
    /** @var int */
    const DEFAULT_EQUATION_BFP = 1;
    /** @var int */
    const DEFAULT_EQUATION_BMR = 1;
    /** @var bool */
    const DEFAULT_SHOW_KILOGRAMS = true;
    /** @var bool */
    const DEFAULT_SHOW_POUNDS = true;
    /** @var bool */
    const DEFAULT_SHOW_STONES = false;

    /** @var float */
    public $startMass;
    /** @var float */
    public $endMass;
    /** @var float */
    public $increment;
    /** @var int */
    public $repeatHeader;

    /** @var bool */
    public $showKilograms;
    /** @var bool */
    public $showPounds;
    /** @var bool */
    public $showStones;

    /** @var int*/
    public $equationBodyMassIndex;
    /** @var int*/
    public $equationBodyFatPercentage;
    /** @var int*/
    public $equationBasalMetabolicRate;
}
