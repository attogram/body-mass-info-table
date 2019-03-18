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

    /** @var float */
    public $startMass;

    /** @var float */
    public $endMass;

    /** @var float */
    public $increment;

    /** @var int */
    public $repeatHeader;
}
