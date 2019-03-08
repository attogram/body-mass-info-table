<?php
declare(strict_types = 1);

namespace Attogram\Body;

/**
 * The Average Human Body
 */
class AverageHuman
{
    /** @var float $height - length, in meters */
    public $height = 0.0;

    /** @var float $age - age, in years */
    public $age = 0.0;

    /** @var string $age - sex, m=male f=female, u=unknown*/
    public $sex = 'u';

    /** @var BodyCalculations Object */
    private $bodyCalculations;

    /**
     * @param float  $height
     * @param float  $age
     * @param string $sex
     */
    public function __construct(float $height = 0.0, float $age = 0.0, string $sex = 'u')
    {
        $this->height = Utils::getFloatVar($height);
        $this->age = Utils::getFloatVar($age);
        $this->sex = in_array($sex, ['m','f','u']) ? $sex : 'u';
        $this->bodyCalculations = new BodyCalculations();
    }
}
